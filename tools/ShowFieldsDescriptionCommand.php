<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tools;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ShowFieldsDescriptionCommand
 *
 * @package Bitrix24\SDK\Tools\PerformanceBenchmarks
 */
class ShowFieldsDescriptionCommand extends Command
{
    protected LoggerInterface $logger;
    protected CoreInterface $core;
    /**
     * @var string
     */
    protected static $defaultName = 'util:show-fields-description';
    protected const WEBHOOK_URL = 'webhook';
    protected const IS_SHOW_TABLE = 'is-show-table';

    /**
     * ListCommand constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * настройки
     */
    protected function configure(): void
    {
        $this
            ->setDescription('show entity fields description with table or phpDoc output format')
            ->setHelp('get list of *.fields methods and show fields description for selected entity')
            ->addOption(
                self::WEBHOOK_URL,
                null,
                InputOption::VALUE_REQUIRED,
                'bitrix24 incoming webhook',
                ''
            )
            ->addOption(
                self::IS_SHOW_TABLE,
                null,
                InputOption::VALUE_OPTIONAL,
                'show fields as table',
                true
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $b24Webhook = (string)$input->getOption(self::WEBHOOK_URL);
        $isShowTable = $input->getOption(self::IS_SHOW_TABLE) === 'true';

        $io = new SymfonyStyle($input, $output);
        try {
            $this->core = (new \Bitrix24\SDK\Core\CoreBuilder())
                ->withLogger($this->logger)
                ->withWebhookUrl($b24Webhook)
                ->build();

            $methods = $this->core->call('methods', ['full' => true])->getResponseData()->getResult()->getResultData();
            $fieldsMethods = [];
            foreach ($methods as $method) {
                if (strpos($method, 'fields') !== false) {
                    $fieldsMethods[] = $method;
                }
            }

            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Please select item number to see fields',
                $fieldsMethods,
                null
            );
            $question->setErrorMessage('Item number %s is invalid.');
            $selectedEntity = $helper->ask($input, $output, $question);
            $output->writeln('You have just selected: ' . $selectedEntity);

            $fields = $this->core->call($selectedEntity);

            if ($isShowTable) {
                var_dump($fields->getResponseData()->getResult()->getResultData());

                $this->showFieldsAsTable($output, $fields);
            } else {
                $this->showFieldsAsPhpDocHeader($output, $fields);
            }
        } catch (BaseException $exception) {
            $io->caution('Bitrix24 error');
            $io->text(
                [
                    sprintf('%s', $exception->getMessage()),
                ]
            );
        } catch (\Throwable $exception) {
            $io->caution('fatal error');
            $io->text(
                [
                    $exception->getMessage(),
                    $exception->getTraceAsString(),
                ]
            );
        }
        $this->logger->debug('ListCommand.start.finish');

        return self::SUCCESS;
    }

    /**
     * @param OutputInterface $output
     * @param Response        $fields
     *
     * @throws BaseException
     */
    private function showFieldsAsPhpDocHeader(OutputInterface $output, Response $fields): void
    {
        $fieldsList = ['/**', '*'];
        foreach ($fields->getResponseData()->getResult()->getResultData() as $fieldCode => $fieldDescription) {
            switch (strtolower($fieldDescription['type'])) {
                case 'integer':
                    $phpDocType = 'int';
                    break;
                case 'datetime':
                    $phpDocType = 'string';
                    break;
                default:
                    $phpDocType = 'string';
            }
            $fieldsList[] = sprintf('* @property-read %s      $%s', $phpDocType, $fieldCode);
        }
        $fieldsList[] = '*/';
        $output->writeln($fieldsList);
    }

    /**
     * @param OutputInterface $output
     * @param Response        $fields
     *
     * @throws BaseException
     */
    private function showFieldsAsTable(OutputInterface $output, Response $fields): void
    {
        $fieldsTable = [];
        // some methods return description in upper case
        $fields = array_change_key_case($fields->getResponseData()->getResult()->getResultData(), CASE_LOWER);

        foreach ($fields as $fieldCode => $fieldDescription) {
            $fieldDescription = array_change_key_case($fieldDescription, CASE_LOWER);
            if (!array_key_exists('title', $fieldDescription)) {
                $fieldDescription['title'] = $fieldCode;
            }

            $fieldsTable[] = [
                $fieldCode,
                $fieldDescription['title'],
                $fieldDescription['type'],
                $fieldDescription['isrequired'] ? 'Y' : '',
                $fieldDescription['isreadonly'] ? 'Y' : '',
                $fieldDescription['isimmutable'] ? 'Y' : '',
                $fieldDescription['ismultiple'] ? 'Y' : '',
                $fieldDescription['isdynamic'] ? 'Y' : '',
            ];
        }

        $table = new Table($output);
        $table
            ->setHeaders(['Code', 'Title', 'Type', 'isRequired', 'isReadOnly', 'isImmutable', 'isMultiple', 'isDynamic'])
            ->setRows($fieldsTable);
        $table->render();
    }
}