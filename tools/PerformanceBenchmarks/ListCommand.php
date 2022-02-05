<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tools\PerformanceBenchmarks;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class ListCommand
 *
 * @package Bitrix24\SDK\Tools\PerformanceBenchmarks
 */
class ListCommand extends Command
{
    protected LoggerInterface $logger;
    protected CoreInterface $core;
    protected BatchInterface $batch;
    /**
     * @var string
     */
    protected static $defaultName = 'benchmark:list';
    protected const TIME_PRECISION = 4;
    protected const SELECT_FIELDS_MODE = 'fields';
    protected const ELEMENTS_COUNT = 'count';
    protected const WEBHOOK_URL = 'webhook';
    protected const ROUNDS_COUNT = 'rounds';
    protected array $benchmarkItems = [
        'order_count'                 => '1. ordered, count total elements',
        'order_without_count'         => '2. ordered, without count total elements',
        'without_order_count'         => '3. default order, count total elements',
        'without_order_without_count' => '4. default order, without count total elements',
    ];
    protected array $selectMode = [
        'partial' => ['ID', 'NAME', 'LAST_NAME', 'DATE_CREATE', 'PHONE', 'EMAIL'],
        'system'  => ['*', 'PHONE', 'EMAIL', 'IM'],
        'all'     => ['*', 'PHONE', 'EMAIL', 'IM', 'UF_*'],
    ];

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
            ->setDescription('performance benchmark for *.list method')
            ->setHelp('performance benchmark for *.list method with simple or batch mode if need read more than 50 elements')
            ->addOption(
                self::WEBHOOK_URL,
                null,
                InputOption::VALUE_REQUIRED,
                'bitrix24 incoming webhook',
                ''
            )
            ->addOption(
                self::ROUNDS_COUNT,
                null,
                InputOption::VALUE_REQUIRED,
                'benchmark rounds count',
                3
            )
            ->addOption(
                self::SELECT_FIELDS_MODE,
                null,
                InputOption::VALUE_REQUIRED,
                'select fields mode (partial | system | all)',
                'all'
            )
            ->addOption(
                self::ELEMENTS_COUNT,
                null,
                InputOption::VALUE_REQUIRED,
                'read elements count',
                50
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
        $this->logger->debug('ListCommand.start');

        $b24Webhook = (string)$input->getOption(self::WEBHOOK_URL);
        $selectFieldsMode = strtolower((string)$input->getOption(self::SELECT_FIELDS_MODE));
        $elementsCount = (int)$input->getOption(self::ELEMENTS_COUNT);
        $roundsCount = (int)$input->getOption(self::ROUNDS_COUNT);

        $isUseBatchMode = false;
        if ($elementsCount > 50) {
            $isUseBatchMode = true;
        }

        $io = new SymfonyStyle($input, $output);
        try {
            $output->writeln(
                [
                    '<info>PerformanceBenchmark for crm.contact.list method</info>',
                    '<info>================================================</info>',
                    sprintf('webhook url: %s', $b24Webhook),
                    sprintf('elements count: %s', $elementsCount),
                    sprintf('is use batch read mode: %s', $isUseBatchMode ? 'yes' : 'no'),
                    sprintf('benchmark rounds count: %s', $roundsCount),
                    sprintf('select fields mode: %s', $selectFieldsMode),
                    '',
                    'fields select modes:',
                    '- partial: ID, NAME, LAST_NAME, DATE_CREATE, PHONE, EMAIL, IM',
                    '- system: *, PHONE, EMAIL, IM',
                    '- all: *, PHONE, EMAIL, IM, UF_*',
                ]
            );

            $this->core = (new CoreBuilder())
                ->withLogger($this->logger)
                ->withWebhookUrl($b24Webhook)
                ->build();
            $this->batch = new Batch(
                $this->core,
                $this->logger
            );

            $countResult = $this->core->call('crm.contact.list');
            $output->writeln(['======', '']);
            $output->writeln(sprintf('contacts total count: %s', $countResult->getResponseData()->getPagination()->getTotal()));


            $order = ['DATE_CREATE' => 'ASC'];
            $filter = ['>ID' => 1];
            if (!array_key_exists($selectFieldsMode, $this->selectMode)) {
                throw new \InvalidArgumentException(sprintf('invalid select mode %s', $selectFieldsMode));
            }
            $select = $this->selectMode[$selectFieldsMode];


            if ($isUseBatchMode) {
                $output->writeln(sprintf('crm.contact.list - get %s elements in batch mode...', $elementsCount));

                $result = $this->batchList($output, $order, $filter, $select, $elementsCount);

                $output->writeln('');
                $table = new Table($output);
                $table->setHeaders(['Mode', 'Time']);
                $table->addRow([$this->benchmarkItems['order_count'], round($result['order_count'], self::TIME_PRECISION)]);
                $table->addRow([$this->benchmarkItems['order_without_count'], round($result['order_without_count'], self::TIME_PRECISION)]);
                $table->addRow([$this->benchmarkItems['without_order_count'], round($result['without_order_count'], self::TIME_PRECISION)]);
                $table->addRow(
                    [
                        $this->benchmarkItems['without_order_without_count'],
                        round($result['without_order_without_count'], self::TIME_PRECISION),
                    ]
                );
                $table->render();
            } else {
                $output->writeln('crm.contact.list - get first 50 elements...');

                // creates a new progress bar (50 units)
                $progressBar = new ProgressBar($output, $roundsCount);
                $progressBar->start();

                $totalStat = [];
                for ($i = 0; $i < $roundsCount; $i++) {
                    $totalStat[] = $this->simpleList($order, $filter, $select);
                    $progressBar->advance();
                }
                $progressBar->finish();
                $output->writeln('');
                $table = new Table($output);
                $table
                    ->setHeaders(['Mode', 'Time']);
                foreach ($this->benchmarkItems as $code => $description) {
                    // calculate average
                    $roundsStat = array_column($totalStat, $code);
                    $value = round(array_sum($roundsStat) / count($roundsStat), self::TIME_PRECISION);
                    $table->addRow(
                        [
                            $this->benchmarkItems[$code],
                            $value,
                        ]
                    );
                }
                $table->render();
            }
            $io->success('benchmark finished');
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
     * @param array           $order
     * @param array           $filter
     * @param array           $select
     * @param int             $elementsCount
     *
     * @return array
     * @throws BaseException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportException
     * @throws TransportExceptionInterface
     */
    protected function batchList(OutputInterface $output, array $order, array $filter, array $select, int $elementsCount): array
    {
        $result = [];

        $output->writeln(['', '1. batch requests - ordered, count total elements...', '']);
        $result['order_count'] = $this->getBatchWithCountQueryTime($output, $order, $filter, $select, $elementsCount);

        $output->writeln(['', '2. batch requests - ordered, without count total elements...', '']);
        $result['order_without_count'] = $this->getBatchWithoutCountQueryTime($output, $order, $filter, $select, $elementsCount);

        $output->writeln(['', '3. batch requests - default order, count total elements...', '']);
        $result['without_order_count'] = $this->getBatchWithCountQueryTime($output, [], $filter, $select, $elementsCount);

        $output->writeln(['', '4. batch requests - default order, without count total elements...', '']);
        $result['without_order_without_count'] = $this->getBatchWithoutCountQueryTime($output, [], $filter, $select, $elementsCount);;

        return $result;
    }

    /**
     * @param OutputInterface $output
     * @param array           $order
     * @param array           $filter
     * @param array           $select
     * @param int             $elementsCount
     *
     * @return float
     * @throws BaseException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportException
     * @throws TransportExceptionInterface
     */
    protected function getBatchWithCountQueryTime(
        OutputInterface $output,
        array $order,
        array $filter,
        array $select,
        int $elementsCount
    ): float {
        $timeStart = microtime(true);
        $progressBar = new ProgressBar($output, $elementsCount);
        $progressBar->setFormat("%current%/%max% [%bar%] %percent:3s%%\n %memory:6s% | %status%\n");
        $progressBar->setMessage('wait first batch query result...', 'status');
        $progressBar->start();

        $elementsFromBatchCount = 0;
        foreach ($this->batch->getTraversableListWithCount('crm.contact.list', $order, $filter, $select, $elementsCount) as $queryItem) {
            $curTime = microtime(true);
            $elementsFromBatchCount++;
            $progressBar->advance();

            $progressBar->setMessage(
                sprintf(
                    ' %s sec |# %s | %s - %s ',
                    round($curTime - $timeStart, 2),
                    $elementsFromBatchCount,
                    $queryItem['ID'],
                    $queryItem['NAME']
                ),
                'status'
            );
        }
        $timeEnd = microtime(true);
        $progressBar->finish();

        return $timeEnd - $timeStart;
    }

    /**
     * @param OutputInterface $output
     * @param array           $order
     * @param array           $filter
     * @param array           $select
     * @param int             $elementsCount
     *
     * @return float
     * @throws BaseException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportException
     * @throws TransportExceptionInterface
     */
    protected function getBatchWithoutCountQueryTime(
        OutputInterface $output,
        array $order,
        array $filter,
        array $select,
        int $elementsCount
    ): float {
        $timeStart = microtime(true);
        $progressBar = new ProgressBar($output, $elementsCount);
        $progressBar->setFormat("%current%/%max% [%bar%] %percent:3s%%\n %memory:6s% | %status%\n");
        $progressBar->setMessage('wait first batch query result...', 'status');
        $progressBar->start();

        $elementsFromBatchCount = 0;
        foreach ($this->batch->getTraversableList('crm.contact.list', $order, $filter, $select, $elementsCount) as $queryItem) {
            $curTime = microtime(true);
            $elementsFromBatchCount++;
            $progressBar->advance();

            $progressBar->setMessage(
                sprintf(
                    ' %s sec |# %s | %s - %s ',
                    round($curTime - $timeStart, 2),
                    $elementsFromBatchCount,
                    $queryItem['ID'],
                    $queryItem['NAME']
                ),
                'status'
            );
        }
        $timeEnd = microtime(true);
        $progressBar->finish();

        return $timeEnd - $timeStart;
    }

    /**
     * @param array $order
     * @param array $filter
     * @param array $select
     *
     * @return array
     * @throws BaseException
     * @throws TransportException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function simpleList(array $order, array $filter, array $select): array
    {
        $default = $this->core->call(
            'crm.contact.list',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => 1,
            ]
        );
        $orderAndNoCount = $this->core->call(
            'crm.contact.list',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => -1,
            ]
        );
        $noOrderAndCount = $this->core->call(
            'crm.contact.list',
            [
                'order'  => [],
                'filter' => $filter,
                'select' => $select,
                'start'  => 1,
            ]
        );
        $noOrderAndNoCount = $this->core->call(
            'crm.contact.list',
            [
                'order'  => [],
                'filter' => $filter,
                'select' => $select,
                'start'  => -1,
            ]
        );

        return [
            'order_count'                 => $default->getResponseData()->getTime()->getDuration(),
            'order_without_count'         => $orderAndNoCount->getResponseData()->getTime()->getDuration(),
            'without_order_count'         => $noOrderAndCount->getResponseData()->getTime()->getDuration(),
            'without_order_without_count' => $noOrderAndNoCount->getResponseData()->getTime()->getDuration(),
        ];
    }
}