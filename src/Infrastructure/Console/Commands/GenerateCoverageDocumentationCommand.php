<?php
/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Infrastructure\Console\Commands;

use Bitrix24\SDK\Attributes\Services\AttributesParser;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Throwable;

#[AsCommand(
    name: 'b24:util:generate-coverage-documentation',
    description: 'generate coverage documentation for all api commands',
    hidden: false
)]
class GenerateCoverageDocumentationCommand extends Command
{
    private const WEBHOOK_URL = 'webhook';
    private const PUBLIC_REPO_URL = 'repository-url';
    private const TARGET_BRANCH = 'repository-branch';
    private const TARGET_FILE = 'file';

    public function __construct(
        private readonly AttributesParser      $attributesParser,
        private readonly ServiceBuilderFactory $serviceBuilderFactory,
        private readonly Finder                $finder,
        private readonly Filesystem            $filesystem,
        private readonly LoggerInterface       $logger)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('generate coverage report for all api commands based on actual methods list from api and api service attributes')
            ->addOption(
                self::WEBHOOK_URL,
                null,
                InputOption::VALUE_REQUIRED,
                'bitrix24 incoming webhook',
                ''
            )
            ->addOption(
                self::PUBLIC_REPO_URL,
                null,
                InputOption::VALUE_REQUIRED,
                'public repository url',
                ''
            )
            ->addOption(
                self::TARGET_BRANCH,
                null,
                InputOption::VALUE_REQUIRED,
                'target branch name',
                ''
            )
            ->addOption(
                self::TARGET_FILE,
                null,
                InputOption::VALUE_REQUIRED,
                'file for generated documentation',
                ''
            );
    }

    private function loadAllServiceClasses(): void
    {
        $directory = 'src/Services';
        $this->finder->files()->in($directory)->name('*.php');
        foreach ($this->finder as $file) {
            if ($file->isDir()) {
                continue;
            }

            $absoluteFilePath = $file->getRealPath();
            require_once $absoluteFilePath;
        }
    }

    /**
     * @param non-empty-string $namespace
     * @return array
     */
    private function getAllSdkClassNames(string $namespace): array
    {
        $allClasses = get_declared_classes();
        return array_filter($allClasses, static function ($class) use ($namespace) {
            return strncmp($class, $namespace, 12) === 0;
        });
    }

    private function createTableInMarkdownFormat(
        array  $supportedInSdkMethods,
        array  $supportedInSdkBatchMethods,
        string $publicRepoUrl,
        string $publicRepoBranch
    ): string
    {
        $tableHeader = <<<EOT
## All bitrix24-php-sdk methods

| **Scope** | **API method with documentation**      | **Description**  | Method in SDK  |
|-----------|----------------------------------------|------------------|----------------|
EOT;

        $table = $tableHeader;
        foreach ($supportedInSdkMethods as $apiMethod) {
            $batchMethodsHint = '';
            if (array_key_exists($apiMethod['name'], $supportedInSdkBatchMethods)) {
                $batchMethodsHint = "<br/><br/>⚡️Batch methods: <br/>";
                $batchMethodsHint .= "<ul>";
                foreach ($supportedInSdkBatchMethods[$apiMethod['name']] as $method) {
                    $batchMethodsHint .= sprintf("<li>`%s`<br/>",
                        $method['sdk_class_name'] . '::' . $method['sdk_method_name']);
                    $batchMethodsHint .= sprintf("Return type: `%s`</li>", $method['sdk_method_return_type_typhoon']);
                }
                $batchMethodsHint .= "</ul>";
            }

            $sdkMethodPublicUrl = sprintf('%s/%s/%s#L%s-L%s',
                $publicRepoUrl,
                $publicRepoBranch,
                $apiMethod['sdk_method_file_name'],
                $apiMethod['sdk_method_file_start_line'],
                $apiMethod['sdk_method_file_end_line'],
            );
            $sdkMethodReturnTypePublicUrl = sprintf('%s/%s/%s',
                $publicRepoUrl,
                $publicRepoBranch,
                $apiMethod['sdk_return_type_file_name']);

            $table .= sprintf("\n|`%s`|[%s](%s)|%s|[`%s`](%s)<br/>Return type<br/>[`%s`](%s)%s|",
                $apiMethod['sdk_scope'] === '' ? '–' : $apiMethod['sdk_scope'],
                $apiMethod['name'],
                $apiMethod['documentation_url'],
                $apiMethod['description'],
                $apiMethod['sdk_class_name'] . '::' . $apiMethod['sdk_method_name'],
                $sdkMethodPublicUrl,
                $apiMethod['sdk_return_type_class'],
                $sdkMethodReturnTypePublicUrl,
                $batchMethodsHint
            );
        }

        return $table;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $b24Webhook = (string)$input->getOption(self::WEBHOOK_URL);
            if ($b24Webhook === '') {
                throw new InvalidArgumentException('you must provide a webhook url in argument «webhook»');
            }
            $publicRepoUrl = (string)$input->getOption(self::PUBLIC_REPO_URL);
            if ($publicRepoUrl === '') {
                throw new InvalidArgumentException('you must provide a public repository url in argument «repository-url»');
            }
            $targetRepoBranch = (string)$input->getOption(self::TARGET_BRANCH);
            if ($targetRepoBranch === '') {
                throw new InvalidArgumentException('you must provide a target repository branch name in argument «repository-branch»');
            }
            $targetFile = (string)$input->getOption(self::TARGET_FILE);
            if ($targetFile === '') {
                throw new InvalidArgumentException('you must provide a file to save generated documentation «file»');
            }
            $this->logger->debug('GenerateCoverageDocumentationCommand.start', [
                'b24Webhook' => $b24Webhook,
                'publicRepoUrl' => $publicRepoUrl,
                'targetRepoBranch' => $targetRepoBranch,
                'targetFile' => $targetFile
            ]);

            $io->info('Generate api coverage report');
            // get all available api methods
            $sb = $this->serviceBuilderFactory->initFromWebhook($b24Webhook);
            $allApiMethods = $sb->getMainScope()->main()->getAvailableMethods()->getResponseData()->getResult();

            // load and filter classes in namespace Bitrix24\SDK from folder src/Services
            $this->loadAllServiceClasses();
            $sdkClassNames = $this->getAllSdkClassNames('Bitrix24\SDK');
            // get sdk root path, change magic number if move current file to another folder depth
            $sdkBasePath = dirname(__FILE__, 5) . '/';

            $supportedInSdkMethods = $this->attributesParser->getSupportedInSdkApiMethods($sdkClassNames, $sdkBasePath);
            $supportedInSdkBatchMethods = $this->attributesParser->getSupportedInSdkBatchMethods($sdkClassNames);

            $allApiMethodsCnt = count($allApiMethods);
            $supportedInSdkMethodsCnt = count($supportedInSdkMethods);
            $supportedInSdkBatchMethodsCnt = count($supportedInSdkBatchMethods);

            // build coverage documentation in Markdown format
            $mdTable = $this->createTableInMarkdownFormat(
                $supportedInSdkMethods,
                $supportedInSdkBatchMethods,
                $publicRepoUrl,
                $targetRepoBranch
            );
            // save documentation to file
            if ($this->filesystem->exists($targetFile)) {
                $this->filesystem->remove($targetFile);
            }
            $this->filesystem->dumpFile($targetFile, $mdTable);

            $output->writeln([
                sprintf('Bitrix24 API-methods count: %d', $allApiMethodsCnt),
                sprintf('Supported in bitrix24-php-sdk methods count: %d', $supportedInSdkMethodsCnt),
                sprintf('Coverage percentage: %s%% 🚀', round(($supportedInSdkMethodsCnt * 100) / $allApiMethodsCnt, 2)),
                '',
                sprintf('Supported in bitrix24-php-sdk methods with batch wrapper count: %d', $supportedInSdkBatchMethodsCnt),
                ''
            ]);

        } catch (Throwable $exception) {
            $io->error(sprintf('runtime error: %s', $exception->getMessage()));
            $io->info($exception->getTraceAsString());

            return self::INVALID;
        }
        return self::SUCCESS;
    }
}