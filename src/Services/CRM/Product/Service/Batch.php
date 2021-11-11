<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Product\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Services\AbstractBatchService;
use Bitrix24\SDK\Services\CRM\Product\Result\ProductItemResult;
use Generator;

/**
 * Class Batch
 *
 * @package Bitrix24\SDK\Services\CRM\Product\Service
 */
class Batch extends AbstractBatchService
{
    /**
     * batch list method
     *
     * @param array{
     *                         ID?: int,
     *
     * @param array{
     *                         ID?: int,
     *                         } $filter
     * @param array    $select = ['ID']
     * @param int|null $limit
     *
     * @return Generator<int, ProductItemResult>
     * @throws BaseException
     */
    public function list(array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug(
            'list',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'limit'  => $limit,
            ]
        );
        foreach ($this->batch->getTraversableList('crm.product.list', $order, $filter, $select, $limit) as $key => $value) {
            yield $key => new ProductItemResult($value);
        }
    }

    /**
     * Batch adding product
     *
     * @param array <int, array{
     *                         ID?: int,
     *                         }> $products
     *
     * @return Generator<int, ProductItemResult>
     */
    public function add(array $products): Generator
    {
        $items = [];
        foreach ($products as $product) {
            $items[] = [
                'fields' => $product,
            ];
        }
        foreach ($this->batch->addEntityItems('crm.product.add', $items) as $key => $item) {
            yield $key => new ProductItemResult(
                [
                    'ID' => $item->getResult()->getResultData()[0],
                ]
            );
        }
    }
}