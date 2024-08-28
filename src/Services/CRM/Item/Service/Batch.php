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

namespace Bitrix24\SDK\Services\CRM\Item\Service;

use Bitrix24\SDK\Attributes\ApiBatchMethodMetadata;
use Bitrix24\SDK\Attributes\ApiBatchServiceMetadata;
use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\DeletedItemBatchResult;
use Bitrix24\SDK\Services\CRM\Item\Result\ItemItemResult;
use Generator;
use Psr\Log\LoggerInterface;

#[ApiBatchServiceMetadata(new Scope(['crm']))]
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
    #[ApiBatchMethodMetadata(
        'crm.item.list',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_list.php',
        'Method returns array with SPA items with entityTypeId.'
    )]
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
     * @return Generator<int, ItemItemResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.item.add',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_add.php',
        'Method creates new SPA item with entityTypeId.'
    )]
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