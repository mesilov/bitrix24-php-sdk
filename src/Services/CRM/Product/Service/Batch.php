<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Product\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AddedItemBatchResult;
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
     *                         ID?: string
     *                         } $order
     *
     * @param array{
     *                         ID?: int
     *                         } $filter
     * @param array    $select = ['ID','CATALOG_ID','PRICE','CURRENCY_ID','NAME','CODE','DESCRIPTION','DESCRIPTION_TYPE','ACTIVE','SECTION_ID','SORT','VAT_ID','VAT_INCLUDED','MEASURE','XML_ID','PREVIEW_PICTURE','DETAIL_PICTURE','DATE_CREATE','TIMESTAMP_X','MODIFIED_BY','CREATED_BY']
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
     *                         CATALOG_ID?: int,
     *                         PRICE?: string,
     *                         CURRENCY_ID?: string,
     *                         NAME?: string,
     *                         CODE?: string,
     *                         DESCRIPTION?: string,
     *                         DESCRIPTION_TYPE?: string,
     *                         ACTIVE?: string,
     *                         SECTION_ID?: int,
     *                         SORT?: int,
     *                         VAT_ID?: int,
     *                         VAT_INCLUDED?: string,
     *                         MEASURE?: int,
     *                         XML_ID?: string,
     *                         PREVIEW_PICTURE?: string,
     *                         DETAIL_PICTURE?: string,
     *                         DATE_CREATE?: string,
     *                         TIMESTAMP_X?: string,
     *                         MODIFIED_BY?: int,
     *                         CREATED_BY?: int
     *                         }> $products
     *
     * @return Generator<int, AddedItemBatchResult>|AddedItemBatchResult[]
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
            yield $key => new AddedItemBatchResult($item);
        }
    }
}