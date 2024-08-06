#!/usr/bin/env php
<?php

use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Services\Workflows\Common\DocumentType;
use Bitrix24\SDK\Tools\Commands\CopyPropertyValues;
use Bitrix24\SDK\Tools\Commands\GenerateContactsCommand;
use Bitrix24\SDK\Tools\Commands\PerformanceBenchmarks\ListCommand;
use Bitrix24\SDK\Tools\Commands\ShowFieldsDescriptionCommand;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\EventDispatcher\EventDispatcher;

if (!in_array(PHP_SAPI, ['cli', 'phpdbg', 'embed'], true)) {
    echo 'Warning: The console should be invoked via the CLI version of PHP, not the ' . PHP_SAPI . ' SAPI' . PHP_EOL;
}

set_time_limit(0);

require dirname(__DIR__, 3) . '/vendor/autoload.php';

if (!class_exists(Dotenv::class)) {
    throw new LogicException('You need to add "symfony/dotenv" as Composer dependencies.');
}

$input = new ArgvInput();
if (null !== $env = $input->getParameterOption(['--env', '-e'], null, true)) {
    putenv('APP_ENV=' . $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = $env);
}

if ($input->hasParameterOption('--no-debug', true)) {
    putenv('APP_DEBUG=' . $_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = '0');
}

(new Dotenv())->bootEnv('.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    if (class_exists(
        Debug::class
    )) {
        Debug::enable();
    }
}

$log = new Logger('bitrix24-php-sdk-cli');
$log->pushHandler(new StreamHandler($_ENV['LOGS_FILE_NAME'], (int)$_ENV['LOGS_LEVEL']));
$log->pushProcessor(new MemoryUsageProcessor(true, true));

$webhookUrl = $_ENV['BITRIX24_WEBHOOK'];
$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
// init bitrix24-php-sdk service with webhook credentials
$b24Service = $b24ServiceFactory->initFromWebhook($webhookUrl);

#[AsCommand(
    name: 'bitrix24-php-sdk:examples:workflows:workflow',
    hidden: false
)]
class workflow extends Command
{
    private LoggerInterface $log;
    private ServiceBuilder $serviceBuilder;

    public function __construct(ServiceBuilder $serviceBuilder, LoggerInterface $logger)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->log = $logger;
        $this->serviceBuilder = $serviceBuilder;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Example of work with workflows')
            ->setHelp('Run workflow for contact')
            ->addOption(
                'workflow-template-id',
                null,
                InputOption::VALUE_REQUIRED,
                'workflow template id',
            )
            ->addOption(
                'contact-id',
                null,
                InputOption::VALUE_REQUIRED,
                'Bitrix24 contact id',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $workflowTemplateId = $input->getOption('workflow-template-id');
        $contactId = $input->getOption('contact-id');
        if ($workflowTemplateId === null) {
            throw new InvalidArgumentException('Missing workflow template id, you must set workflow-template-id');
        }
        if ($contactId === null) {
            throw new InvalidArgumentException('Missing contact id, you must set contact-id');
        }
        $output->writeln([
            'Work with workflow example',
            '',
            sprintf('workflow template id: %s', $workflowTemplateId),
            sprintf('contact id: %s', $contactId),
            '',
            'run workflow for contact...'
        ]);

        // run workflow
        $workflowInstanceId = $this->serviceBuilder->getBizProcScope()->workflow()->start(
            DocumentType::crmContact,
            $workflowTemplateId,
            $contactId,
        )->getRunningWorkflowInstanceId();
        $output->writeln(sprintf('running workflow instance id: %s', $workflowInstanceId));

        // get running workflow instance list
        $workflowInstances = $this->serviceBuilder->getBizProcScope()->workflow()->instances(
            [],
            [],
            [
                'ENTITY' => DocumentType::crmContact->value
            ]
        )->getInstances();
        var_dump($workflowInstances);


        // try to terminate workflow
        $terminationResult = $this->serviceBuilder->getBizProcScope()->workflow()->terminate(
            $workflowInstanceId,
            'terminated!'
        );

        var_dump($terminationResult->isSuccess());


        return 0;
    }
}

$application = new Application();
$application->add(new workflow($b24Service, $log));
$application->run($input);
