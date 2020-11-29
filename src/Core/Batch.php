<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Commands\CommandCollection;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\DTO\Pagination;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;
use Bitrix24\SDK\Core\Response\DTO\Result;
use Bitrix24\SDK\Core\Response\DTO\Time;
use Bitrix24\SDK\Core\Response\Response;
use Psr\Log\LoggerInterface;
use Traversable;

/**
 * Class Batch
 *
 * @package Bitrix24\SDK\Core
 */
class Batch
{
    /**
     * @var Core
     */
    private $coreService;
    /**
     * @var LoggerInterface
     */
    private $log;
    /**
     * @var int
     */
    protected const MAX_BATCH_PACKET_SIZE = 50;
    /**
     * @var CommandCollection
     */
    protected $commands;

    /**
     * Batch constructor.
     *
     * @param Core            $core
     * @param LoggerInterface $log
     */
    public function __construct(Core $core, LoggerInterface $log)
    {
        $this->coreService = $core;
        $this->log = $log;
        $this->commands = new CommandCollection();
    }

    /**
     * Clear api commands collection
     */
    public function clearCommands(): void
    {
        $this->commands = new CommandCollection();
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
        $this->commands->attach(new Command($apiMethod, $parameters, $commandName));
    }

    /**
     * @param bool $isHaltOnError
     *
     * @return Response
     * @throws BaseException
     * @throws Exceptions\InvalidArgumentException
     * @throws \JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTraversable(bool $isHaltOnError): Traversable
    {
        foreach ($this->getTraversableBatchResults($isHaltOnError) as $batchItem => $batchResult) {
            /**
             * @var $batchResult Response
             */
            $response = $batchResult->getResponseData();

            $resultDataItems = $response->getResult()->getResultData()['result'];
            $resultQueryTimeItems = $response->getResult()->getResultData()['result_time'];
            foreach ($resultDataItems as $singleQueryKey => $singleQueryResult) {
                if (!is_array($singleQueryResult)) {
                    $singleQueryResult = [$singleQueryResult];
                }
                if (!array_key_exists($singleQueryKey, $resultQueryTimeItems)) {
                    throw new BaseException(sprintf('query time with key %s not found', $singleQueryKey));
                }

                // todo, посмотреть, что будет постраничке для батч-запросов на чтение
                yield new ResponseData(
                    new Result($singleQueryResult),
                    Time::initFromResponse($resultQueryTimeItems[$singleQueryKey]),
                    new Pagination(null, null)
                );
            }
        }
    }

    /**
     * @param bool $isHaltOnError
     *
     * @return Traversable
     * @throws BaseException
     * @throws Exceptions\InvalidArgumentException
     * @throws \JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function getTraversableBatchResults(bool $isHaltOnError): Traversable
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
            $batchResult = $this->coreService->call('batch', ['halt' => $isHaltOnError, 'cmd' => $batchQuery]);
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