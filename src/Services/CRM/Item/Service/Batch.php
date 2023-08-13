<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Item\Service;

use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\DeletedItemBatchResult;
use Bitrix24\SDK\Services\CRM\Item\Result\ItemItemResult;
use Generator;
use Psr\Log\LoggerInterface;

class Batch
{
    protected BatchOperationsInterface $batch;
    protected LoggerInterface $log;

    public function __construct(BatchOperationsInterface $batch, LoggerInterface $log)
    {
        $this->batch = $batch;
        $this->log = $log;
    }

    /**
     * Batch list method for crm items
     *
     * @return Generator<int, ItemItemResult>
     * @throws BaseException
     */
    public function list(int $entityTypeId, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug(
            'batchList',
            [
                'entityTypeId' => $entityTypeId,
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
                'limit' => $limit,
            ]
        );
        foreach ($this->batch->getTraversableList('crm.item.list', $order, $filter, $select, $limit, ['entityTypeId' => $entityTypeId]) as $key => $value) {
            yield $key => new ItemItemResult($value);
        }
    }

    /**
     * Batch adding crm items
     *
     * @return Generator<int, ItemItemResult>|ItemItemResult[]
     *
     * @throws BaseException
     */
    public function add(int $entityTypeId, array $items): Generator
    {
        $rawItems = [];
        foreach ($items as $item) {
            $rawItems[] = [
                'entityTypeId' => $entityTypeId,
                'fields' => $item,
            ];
        }
        foreach ($this->batch->addEntityItems('crm.item.add', $rawItems) as $key => $item) {
            yield $key => new ItemItemResult($item->getResult()['item']);
        }
    }
}