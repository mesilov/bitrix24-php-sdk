<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies;

use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Generator;
use Psr\Log\LoggerInterface;

class FilterWithBatchWithoutCountOrder implements BulkItemsReaderInterface
{
    private BatchInterface $batch;
    private LoggerInterface $log;

    /**
     * @param \Bitrix24\SDK\Core\Contracts\BatchInterface $batch
     * @param \Psr\Log\LoggerInterface                    $log
     */
    public function __construct(BatchInterface $batch, LoggerInterface $log)
    {
        $this->batch = $batch;
        $this->log = $log;
    }

    /**
     * @param string   $apiMethod
     * @param array    $order
     * @param array    $filter
     * @param array    $select
     * @param int|null $limit
     *
     * @return \Generator
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug('FilterWithBatchWithoutCountOrder.getTraversableList.start', [
            'apiMethod' => $apiMethod,
            'order'     => $order,
            'filter'    => $filter,
            'select'    => $select,
            'limit'     => $limit,
        ]);

        foreach ($this->batch->getTraversableList($apiMethod, $order, $filter, $select, $limit) as $cnt => $resultItem) {
            yield $cnt => $resultItem;
        }

        $this->log->debug('FilterWithBatchWithoutCountOrder.getTraversableList.finish');
    }
}