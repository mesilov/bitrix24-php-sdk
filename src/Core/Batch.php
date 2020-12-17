<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Commands\CommandCollection;
use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
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
    private LoggerInterface $log;
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
        $this->log = $log;
        $this->commands = new CommandCollection();
    }

    /**
     * Clear api commands collection
     */
    public function clearCommands(): void
    {
        $this->log->debug(
            'clearCommands.start',
            [
                'commandsCount' => $this->commands->count(),
            ]
        );
        $this->commands = new CommandCollection();
        $this->log->debug('clearCommands.finish');
    }

    /**
     * add api command to commands collection for batch calls
     *
     * @param string        $apiMethod
     * @param array         $parameters
     * @param string|null   $commandName
     * @param callable|null $callback
     *
     * @throws \Exception
     */
    public function addCommand(
        string $apiMethod,
        array $parameters = [],
        ?string $commandName = null,
        callable $callback = null
    ) {
        $this->log->debug(
            'addCommand.start',
            [
                'apiMethod'   => $apiMethod,
                'parameters'  => $parameters,
                'commandName' => $commandName,
            ]
        );

        $this->commands->attach(new Command($apiMethod, $parameters, $commandName));

        $this->log->debug(
            'addCommand.finish',
            [
                'commandsCount' => $this->commands->count(),
            ]
        );
    }

    /**
     * batch wrapper for *.list methods
     *
     * work with start item position and elements count
     *
     * @param string   $apiMethod
     * @param array    $order
     * @param array    $filter
     * @param array    $select
     * @param int|null $limit
     *
     * @return Generator
     * @throws BaseException
     * @throws Exceptions\TransportException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug(
            'getTraversableList.start',
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

        $this->log->debug(
            'getTraversableList.calculateCommandsRange',
            [
                'nextItem'   => $nextItem,
                'totalItems' => $total,
            ]
        );

        if ($total > self::MAX_ELEMENTS_IN_PAGE && $nextItem !== null) {
            //more than one page in results -  register list commands
            for ($startItem = 0; $startItem <= $total; $startItem += $nextItem) {
                $this->addCommand(
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
            $this->addCommand(
                $apiMethod,
                [
                    'order'  => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start'  => 0,
                ]
            );
        }

        $this->log->debug(
            'getTraversableList.commandsRegistered',
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
            $this->log->debug(
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

        $this->log->debug('getTraversableList.finish');
    }

    /**
     * @param bool $isHaltOnError
     *
     * @return Generator
     * @throws BaseException
     * @throws Exceptions\TransportException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTraversable(bool $isHaltOnError): Generator
    {
        $this->log->debug(
            'getTraversable.start',
            [
                'isHaltOnError' => $isHaltOnError,
            ]
        );

        foreach ($this->getTraversableBatchResults($isHaltOnError) as $batchItem => $batchResult) {
            /**
             * @var $batchResult Response
             */
            $this->log->debug(
                'getTraversable.batchResultItem.processStart',
                [
                    'batchItemNumber'     => $batchItem,
                    'batchApiCommand'     => $batchResult->getApiCommand()->getApiMethod(),
                    'batchApiCommandUuid' => $batchResult->getApiCommand()->getUuid()->toString(),
                ]
            );
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
                if ($resultNextItems !== null && array_key_exists($singleQueryKey, $resultNextItems) && count($resultNextItems) > 0) {
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
            $this->log->debug('getTraversable.batchResult.processFinish');
        }
        $this->log->debug('getTraversable.finish');
    }

    /**
     * @param bool $isHaltOnError
     *
     * @return Generator
     * @throws BaseException
     * @throws Exceptions\TransportException
     */
    private function getTraversableBatchResults(bool $isHaltOnError): Generator
    {
        $this->log->debug(
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
            $this->log->debug(
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
        $this->log->debug('getTraversableBatchResults.finish');
    }

    /**
     * @return array
     */
    private function convertToApiCommands(): array
    {
        $apiCommands = [];
        foreach ($this->commands as $itemCommand) {
            /**
             * @var $itemCommand Command
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