<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Commands\CommandCollection;
use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Response\DTO\Pagination;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;
use Bitrix24\SDK\Core\Response\DTO\Result;
use Bitrix24\SDK\Core\Response\DTO\Time;
use Bitrix24\SDK\Core\Response\Response;
use Generator;
use Psr\Log\LoggerInterface;

/**
 * Class Batch
 *
 * @package Bitrix24\SDK\Core
 */
class Batch implements BatchInterface
{
    private CoreInterface $core;
    private LoggerInterface $logger;
    protected const MAX_BATCH_PACKET_SIZE = 50;
    protected const MAX_ELEMENTS_IN_PAGE = 50;
    protected CommandCollection $commands;

    /**
     * Batch constructor.
     *
     * @param CoreInterface   $core
     * @param LoggerInterface $log
     */
    public function __construct(CoreInterface $core, LoggerInterface $log)
    {
        $this->core = $core;
        $this->logger = $log;
        $this->commands = new CommandCollection();
    }

    /**
     * Clear api commands collection
     */
    protected function clearCommands(): void
    {
        $this->logger->debug(
            'clearCommands.start',
            [
                'commandsCount' => $this->commands->count(),
            ]
        );
        $this->commands = new CommandCollection();
        $this->logger->debug('clearCommands.finish');
    }

    /**
     * Add entity items with batch call
     *
     * @param string            $apiMethod
     * @param array<int, mixed> $entityItems
     *
     * @return Generator<int, ResponseData>|ResponseData[]
     * @throws BaseException
     */
    public function addEntityItems(string $apiMethod, array $entityItems): Generator
    {
        $this->logger->debug(
            'addEntityItems.start',
            [
                'apiMethod'   => $apiMethod,
                'entityItems' => $entityItems,
            ]
        );

        try {
            $this->clearCommands();
            foreach ($entityItems as $cnt => $item) {
                $this->registerCommand($apiMethod, $item);
            }

            foreach ($this->getTraversable(true) as $cnt => $addedItemResult) {
                yield $cnt => $addedItemResult;
            }
        } catch (\Throwable $exception) {
            $errorMessage = sprintf('batch add entity items: %s', $exception->getMessage());
            $this->logger->error(
                $errorMessage,
                [
                    'trace' => $exception->getTrace(),
                ]
            );

            throw new BaseException($errorMessage, $exception->getCode(), $exception);
        }

        $this->logger->debug('addEntityItems.finish');
    }

    /**
     * Delete entity items with batch call
     *
     * @param string          $apiMethod
     * @param array<int, int> $entityItemId
     *
     * @return Generator<int, ResponseData>|ResponseData[]
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function deleteEntityItems(string $apiMethod, array $entityItemId): Generator
    {
        $this->logger->debug(
            'deleteEntityItems.start',
            [
                'apiMethod'   => $apiMethod,
                'entityItems' => $entityItemId,
            ]
        );

        try {
            $this->clearCommands();
            foreach ($entityItemId as $cnt => $itemId) {
                if (!is_int($itemId)) {
                    throw new InvalidArgumentException(
                        sprintf(
                            'invalid type «%s» of entity id «%s» at position %s, entity id must be integer type',
                            gettype($itemId),
                            $itemId,
                            $cnt
                        )
                    );
                }
                $this->registerCommand($apiMethod, ['ID' => $itemId]);
            }

            foreach ($this->getTraversable(true) as $cnt => $deletedItemResult) {
                yield $cnt => $deletedItemResult;
            }
        } catch (InvalidArgumentException $exception) {
            $errorMessage = sprintf('batch delete entity items: %s', $exception->getMessage());
            $this->logger->error(
                $errorMessage,
                [
                    'trace' => $exception->getTrace(),
                ]
            );
            throw $exception;
        } catch (\Throwable $exception) {
            $errorMessage = sprintf('batch delete entity items: %s', $exception->getMessage());
            $this->logger->error(
                $errorMessage,
                [
                    'trace' => $exception->getTrace(),
                ]
            );

            throw new BaseException($errorMessage, $exception->getCode(), $exception);
        }

        $this->logger->debug('deleteEntityItems.finish');
    }

    /**
     * Register api command to command collection for batch calls
     *
     * @param string             $apiMethod
     * @param array<mixed,mixed> $parameters
     * @param string|null        $commandName
     * @param callable|null      $callback not implemented
     *
     * @throws \Exception
     */
    protected function registerCommand(
        string $apiMethod,
        array $parameters = [],
        ?string $commandName = null,
        callable $callback = null
    ): void {
        $this->logger->debug(
            'registerCommand.start',
            [
                'apiMethod'   => $apiMethod,
                'parameters'  => $parameters,
                'commandName' => $commandName,
            ]
        );

        $this->commands->attach(new Command($apiMethod, $parameters, $commandName));

        $this->logger->debug(
            'registerCommand.finish',
            [
                'commandsCount' => $this->commands->count(),
            ]
        );
    }

    /**
     * @param array<string,string> $order
     *
     * @return array|string[]
     */
    protected function getReverseOrder(array $order): array
    {
        $this->logger->debug(
            'getReverseOrder.start',
            [
                'order' => $order,
            ]
        );
        $reverseOrder = null;

        if ($order === []) {
            $reverseOrder = ['ID' => 'DESC'];
        } else {
            $order = array_change_key_case($order, CASE_UPPER);
            $oldDirection = array_values($order)[0];
            if ($oldDirection === 'ASC') {
                $newOrderDirection = 'DESC';
            } else {
                $newOrderDirection = 'ASC';
            }
            $reverseOrder[array_key_first($order)] = $newOrderDirection;
        }

        $this->logger->debug(
            'getReverseOrder.finish',
            [
                'order' => $reverseOrder,
            ]
        );

        return $reverseOrder;
    }

    /**
     * Get traversable list without count elements
     *
     * @param string               $apiMethod
     * @param array<string,string> $order
     * @param array<string,mixed>  $filter
     * @param array<string,mixed>  $select
     * @param int|null             $limit
     *
     * @return \Generator<mixed>
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTraversableList(
        string $apiMethod,
        array $order,
        array $filter,
        array $select,
        ?int $limit = null
    ): Generator {
        $this->logger->debug('getTraversableList.start',
                             [
                                 'apiMethod' => $apiMethod,
                                 'order'     => $order,
                                 'filter'    => $filter,
                                 'select'    => $select,
                                 'limit'     => $limit,
                             ]
        );

        // strategy.3 — ID filter, batch, no count, order
        // — ✅ отключён подсчёт количества элементов в выборке
        // — ⚠️ ID элементов в выборке возрастает, т.е. была сделана сортировка результатов по ID
        // — используем batch
        // — последовательное выполнение запросов
        //
        // Задел по оптимизации
        // — ограниченное использование параллельных запросов
        //
        // Запросы отправляются к серверу последовательно с параметром "order": {"ID": "ASC"} (сортировка по возрастанию ID).
        // Т.к. результаты отсортированы по возрастанию ID, то их можно объеденить в батч-запросы с отключённым подсчётом количества элементов в каждом.
        //
        // Порядок формирования фильтра:
        //
        // взяли фильтр с «прямой» сортировкой и получили первый ID
        // взяли фильтр с «обратной» сортировкой и получили последний ID
        // Т.к. ID монотонно возрастает, то делаем предположение, что все страницы заполнены элементами равномерно, на самом деле там будут «дыры» из-за мастер-мастер репликации и удалённых элементов. т.е. в результирующих выборках не всегда будет ровно 50 элементов.
        // из готовых фильтров формируем выборки и упаковываем их в батч-команды.
        // по возможности, батч-запросы выполняются параллельно

        // получили первый id элемента в выборке по фильтру
        // todo проверили, что это *.list команда
        // todo проверили, что в селекте есть ID, т.е. разработчик понимает, что ID используется
        // todo проверили, что сортировка задана как "order": {"ID": "ASC"} т.е. разработчик понимает, что данные придут в таком порядке
        // todo проверили, что если есть limit, то он >1
        // todo проверили, что в фильтре нет поля ID, т.к. мы с ним будем работать


        $firstResultPage = $this->core->call(
            $apiMethod,
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => 0,
            ]
        );
        $totalElementsCount = $firstResultPage->getResponseData()->getPagination()->getTotal();
        // filtered elements count less than or equal one result page(50 elements)
        $elementsCounter = 0;
        if ($totalElementsCount <= self::MAX_ELEMENTS_IN_PAGE) {
            foreach ($firstResultPage->getResponseData()->getResult()->getResultData() as $cnt => $listElement) {
                $elementsCounter++;
                if ($limit !== null && $elementsCounter > $limit) {
                    return;
                }
                yield $listElement;
            }
            $this->logger->debug('getTraversableList.finish');

            return;
        }

        // filtered elements count more than one result page(50 elements)
        // return first page
        $lastElementIdInFirstPage = null;
        foreach ($firstResultPage->getResponseData()->getResult()->getResultData() as $cnt => $listElement) {
            $elementsCounter++;
            $lastElementIdInFirstPage = $listElement['ID'];
            if ($limit !== null && $elementsCounter > $limit) {
                return;
            }
            yield $listElement;
        }

        $this->clearCommands();
        if (!in_array('ID', $select, true)) {
            $select[] = 'ID';
        }

        // getLastElementId in filtered result
        $lastResultPage = $this->core->call(
            $apiMethod,
            [
                'order'  => $this->getReverseOrder($order),
                'filter' => $filter,
                'select' => $select,
                'start'  => 0,
            ]
        );

        $lastElementId = (int)$lastResultPage->getResponseData()->getResult()->getResultData()[0]['ID'];

        // register commands with updated filter
        //more than one page in results -  register list commands
        $lastElementIdInFirstPage++;
        for ($startId = $lastElementIdInFirstPage; $startId <= $lastElementId; $startId += self::MAX_ELEMENTS_IN_PAGE) {
            $this->logger->debug('registerCommand.item', [
                'startId'       => $startId,
                'lastElementId' => $lastElementId,
                'delta'         => $lastElementId - $startId,
            ]);

            $delta = $lastElementId - $startId;
            $isLastPage = false;
            if ($delta > self::MAX_ELEMENTS_IN_PAGE) {
                // ignore
                // - master–master replication with id
                // - deleted elements
                $lastElementIdInPage = $startId + self::MAX_ELEMENTS_IN_PAGE;
            } else {
                $lastElementIdInPage = $lastElementId;
                $isLastPage = true;
            }

            $this->registerCommand(
                $apiMethod,
                [
                    'order'  => [],
                    'filter' => $this->updateFilterForBatch($startId, $lastElementIdInPage, $isLastPage, $filter),
                    'select' => $select,
                    'start'  => -1,
                ]
            );
        }
        $this->logger->debug(
            'getTraversableList.commandsRegistered',
            [
                'commandsCount' => $this->commands->count(),
            ]
        );

        // iterate batch queries, max:  50 results per 50 elements in each result
        $elementsCounter = 0;
        foreach ($this->getTraversable(true) as $queryCnt => $queryResultData) {
            /**
             * @var $queryResultData ResponseData
             */
            $this->logger->debug(
                'getTraversableList.batchResultItem',
                [
                    'batchCommandItemNumber' => $queryCnt,
                    'nextItem'               => $queryResultData->getPagination()->getNextItem(),
                    'durationTime'           => $queryResultData->getTime()->getDuration(),
                ]
            );
            // iterate items in batch query result
            foreach ($queryResultData->getResult()->getResultData() as $cnt => $listElement) {
                $elementsCounter++;
                if ($limit !== null && $elementsCounter > $limit) {
                    return;
                }
                yield $listElement;
            }
        }
        $this->logger->debug('getTraversableList.finish');
    }

    /**
     * @param int                 $startElementId
     * @param int                 $lastElementId
     * @param bool                $isLastPage
     * @param array<string,mixed> $oldFilter
     *
     * @return array<string,mixed>
     */
    protected function updateFilterForBatch(int $startElementId, int $lastElementId, bool $isLastPage, array $oldFilter): array
    {
        $this->logger->debug('updateFilterForBatch.start', [
            'startElementId' => $startElementId,
            'lastElementId'  => $lastElementId,
            'isLastPage'     => $isLastPage,
            'oldFilter'      => $oldFilter,
        ]);

        $filter = array_merge(
            $oldFilter,
            [
                '>=ID'                       => $startElementId,
                $isLastPage ? '<=ID' : '<ID' => $lastElementId,
            ]
        );
        $this->logger->debug('updateFilterForBatch.finish', [
            'filter' => $filter,
        ]);

        return $filter;
    }

    /**
     * batch wrapper for *.list methods
     *
     * work with start item position and elements count
     *
     * @param string               $apiMethod
     * @param array<string,string> $order
     * @param array<string,mixed>  $filter
     * @param array<string,mixed>  $select
     * @param int|null             $limit
     *
     * @return Generator<mixed>
     * @throws BaseException
     * @throws Exceptions\TransportException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Exception
     */
    public function getTraversableListWithCount(
        string $apiMethod,
        array $order,
        array $filter,
        array $select,
        ?int $limit = null
    ): Generator {
        $this->logger->debug(
            'getTraversableListWithCount.start',
            [
                'apiMethod' => $apiMethod,
                'order'     => $order,
                'filter'    => $filter,
                'select'    => $select,
                'limit'     => $limit,
            ]
        );
        $this->clearCommands();

        // get total elements count
        $firstResult = $this->core->call(
            $apiMethod,
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => 0,
            ]
        );

        $nextItem = $firstResult->getResponseData()->getPagination()->getNextItem();
        $total = $firstResult->getResponseData()->getPagination()->getTotal();

        $this->logger->debug(
            'getTraversableListWithCount.calculateCommandsRange',
            [
                'nextItem'   => $nextItem,
                'totalItems' => $total,
            ]
        );

        if ($total > self::MAX_ELEMENTS_IN_PAGE && $nextItem !== null) {
            //more than one page in results -  register list commands
            for ($startItem = 0; $startItem <= $total; $startItem += $nextItem) {
                $this->registerCommand(
                    $apiMethod,
                    [
                        'order'  => $order,
                        'filter' => $filter,
                        'select' => $select,
                        'start'  => $startItem,
                    ]
                );
                if ($limit !== null && $limit < $startItem) {
                    break;
                }
            }
        } else {
            // one page in results
            $this->registerCommand(
                $apiMethod,
                [
                    'order'  => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start'  => 0,
                ]
            );
        }

        $this->logger->debug(
            'getTraversableListWithCount.commandsRegistered',
            [
                'commandsCount'      => $this->commands->count(),
                'totalItemsToSelect' => $total,
            ]
        );

        // iterate batch queries, max:  50 results per 50 elements in each result
        $elementsCounter = 0;
        foreach ($this->getTraversable(true) as $queryCnt => $queryResultData) {
            /**
             * @var $queryResultData ResponseData
             */
            $this->logger->debug(
                'getTraversableListWithCount.batchResultItem',
                [
                    'batchCommandItemNumber' => $queryCnt,
                    'nextItem'               => $queryResultData->getPagination()->getNextItem(),
                    'durationTime'           => $queryResultData->getTime()->getDuration(),
                ]
            );
            // iterate items in batch query result
            foreach ($queryResultData->getResult()->getResultData() as $cnt => $listElement) {
                $elementsCounter++;
                if ($limit !== null && $elementsCounter > $limit) {
                    return;
                }
                yield $listElement;
            }
        }

        $this->logger->debug('getTraversableListWithCount.finish');
    }

    /**
     * @param bool $isHaltOnError
     *
     * @return Generator<int, ResponseData>
     * @throws BaseException
     * @throws Exceptions\TransportException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Exception
     */
    protected function getTraversable(bool $isHaltOnError): Generator
    {
        $this->logger->debug(
            'getTraversable.start',
            [
                'isHaltOnError' => $isHaltOnError,
            ]
        );

        foreach ($this->getTraversableBatchResults($isHaltOnError) as $batchItem => $batchResult) {
            /**
             * @var $batchResult Response
             */
            $this->logger->debug(
                'getTraversable.batchResultItem.processStart',
                [
                    'batchItemNumber'     => $batchItem,
                    'batchApiCommand'     => $batchResult->getApiCommand()->getApiMethod(),
                    'batchApiCommandUuid' => $batchResult->getApiCommand()->getUuid()->toString(),
                ]
            );
            // todo try to multiplex requests
            $response = $batchResult->getResponseData();

            // single queries
            // todo handle error field
            $resultDataItems = $response->getResult()->getResultData()['result'];
            $resultQueryTimeItems = $response->getResult()->getResultData()['result_time'];

            // list queries
            //todo handle result_error for list queries
            $resultNextItems = $response->getResult()->getResultData()['result_next'];
            $totalItems = $response->getResult()->getResultData()['result_total'];
            foreach ($resultDataItems as $singleQueryKey => $singleQueryResult) {
                if (!is_array($singleQueryResult)) {
                    $singleQueryResult = [$singleQueryResult];
                }
                if (!array_key_exists($singleQueryKey, $resultQueryTimeItems)) {
                    throw new BaseException(sprintf('query time with key %s not found', $singleQueryKey));
                }

                $nextItem = null;
                if ($resultNextItems !== null && array_key_exists($singleQueryKey, $resultNextItems)) {
                    $nextItem = $resultNextItems[$singleQueryKey];
                }

                $total = null;
                if ($totalItems !== null && count($totalItems) > 0) {
                    $total = $totalItems[$singleQueryKey];
                }

                yield new ResponseData(
                    new Result($singleQueryResult),
                    Time::initFromResponse($resultQueryTimeItems[$singleQueryKey]),
                    new Pagination($nextItem, $total)
                );
            }
            $this->logger->debug('getTraversable.batchResult.processFinish');
        }
        $this->logger->debug('getTraversable.finish');
    }

    /**
     * @param bool $isHaltOnError
     *
     * @return Generator<Response>
     * @throws BaseException
     * @throws Exceptions\TransportException
     */
    private function getTraversableBatchResults(bool $isHaltOnError): Generator
    {
        $this->logger->debug(
            'getTraversableBatchResults.start',
            [
                'commandsCount' => $this->commands->count(),
                'isHaltOnError' => $isHaltOnError,
            ]
        );

        // todo check unique names if exists
        // конвертируем во внутренние представление батч-команд
        $apiCommands = $this->convertToApiCommands();
        $batchQueryCounter = 0;
        while (count($apiCommands)) {
            $batchQuery = array_splice($apiCommands, 0, self::MAX_BATCH_PACKET_SIZE);
            $this->logger->debug(
                'getTraversableBatchResults.batchQuery',
                [
                    'batchQueryNumber' => $batchQueryCounter,
                    'queriesCount'     => count($batchQuery),
                ]
            );
            // batch call
            $batchResult = $this->core->call('batch', ['halt' => $isHaltOnError, 'cmd' => $batchQuery]);
            // todo analyze batch result and halt on error

            $batchQueryCounter++;
            yield $batchResult;
        }
        $this->logger->debug('getTraversableBatchResults.finish');
    }

    /**
     * @return array<string, string>
     */
    private function convertToApiCommands(): array
    {
        $apiCommands = [];
        foreach ($this->commands as $itemCommand) {
            /**
             * @var Command $itemCommand
             */
            $apiCommands[$itemCommand->getName() ?? $itemCommand->getUuid()->toString()] = sprintf(
                '%s?%s',
                $itemCommand->getApiMethod(),
                http_build_query($itemCommand->getParameters())
            );
        }

        return $apiCommands;
    }
}