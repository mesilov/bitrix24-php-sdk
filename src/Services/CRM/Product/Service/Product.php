<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Product\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Product\Result\ProductResult;
use Bitrix24\SDK\Services\CRM\Product\Result\ProductsResult;
use Psr\Log\LoggerInterface;

/**
 * Class Product
 *
 * @package Bitrix24\SDK\Services\CRM\Product\Service
 */
class Product extends AbstractService
{
    public Batch $batch;

    /**
     * Product constructor.
     *
     * @param Batch           $batch
     * @param CoreInterface   $core
     * @param LoggerInterface $log
     */
    public function __construct(Batch $batch, CoreInterface $core, LoggerInterface $log)
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
    }

    /**
     * Add new product
     *
     * @link https://training.bitrix24.com/rest_help/crm/products/crm_product_add.php
     *
     * @param array{
     *   ID?: int,
     *   CATALOG_ID?: int,
     *   PRICE?: string,
     *   CURRENCY_ID?: string,
     *   NAME?: string,
     *   CODE?: string,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   ACTIVE?: string,
     *   SECTION_ID?: int,
     *   SORT?: int,
     *   VAT_ID?: int,
     *   VAT_INCLUDED?: string,
     *   MEASURE?: int,
     *   XML_ID?: string,
     *   PREVIEW_PICTURE?: string,
     *   DETAIL_PICTURE?: string,
     *   DATE_CREATE?: string,
     *   TIMESTAMP_X?: string,
     *   MODIFIED_BY?: int,
     *   CREATED_BY?: int
     *   } $fields
     *
     * @return AddedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function add(array $fields): AddedItemResult
    {
        return new AddedItemResult(
            $this->core->call(
                'crm.product.add',
                [
                    'fields' => $fields,
                ]
            )
        );
    }

    /**
     * Delete product by id
     *
     * @link https://training.bitrix24.com/rest_help/crm/products/crm_product_delete.php
     *
     * @param int $productId
     *
     * @return \Bitrix24\SDK\Core\Result\DeletedItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function delete(int $productId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.product.delete',
                [
                    'id' => $productId,
                ]
            )
        );
    }

    /**
     * Returns a product by the product id.
     *
     * @link https://training.bitrix24.com/rest_help/crm/products/crm_product_get.php
     *
     * @param int $id
     *
     * @return \Bitrix24\SDK\Services\CRM\Product\Result\ProductResult
     * @throws BaseException
     * @throws TransportException
     */
    public function get(int $id): ProductResult
    {
        return new ProductResult($this->core->call('crm.product.get', ['id' => $id]));
    }

    /**
     * Returns the description of the product fields, including user fields.
     *
     * @link https://training.bitrix24.com/rest_help/crm/products/crm_product_fields.php
     *
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.product.fields'));
    }

    /**
     * Get list of product items.
     *
     * @link https://training.bitrix24.com/rest_help/crm/products/crm_product_list.php
     *
     * @param array $order     - order of product items
     * @param array $filter    - filter array
     * @param array $select    = ['ID','CATALOG_ID','PRICE','CURRENCY_ID','NAME','CODE','DESCRIPTION','DESCRIPTION_TYPE','ACTIVE','SECTION_ID','SORT','VAT_ID','VAT_INCLUDED','MEASURE','XML_ID','PREVIEW_PICTURE','DETAIL_PICTURE','DATE_CREATE','TIMESTAMP_X','MODIFIED_BY','CREATED_BY']
     * @param int   $startItem - entity number to start from (usually returned in 'next' field of previous 'crm.product.list' API call)
     *
     * @return ProductsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function list(array $order, array $filter, array $select, int $startItem = 0): ProductsResult
    {
        return new ProductsResult(
            $this->core->call(
                'crm.product.list',
                [
                    'order'  => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start'  => $startItem,
                ]
            )
        );
    }

    /**
     * Updates the specified (existing) product.
     *
     * @link https://training.bitrix24.com/rest_help/crm/products/crm_product_update.php
     *
     * @param int $id
     * @param array{
     *   ID?: int,
     *   CATALOG_ID?: int,
     *   PRICE?: string,
     *   CURRENCY_ID?: string,
     *   NAME?: string,
     *   CODE?: string,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   ACTIVE?: string,
     *   SECTION_ID?: int,
     *   SORT?: int,
     *   VAT_ID?: int,
     *   VAT_INCLUDED?: string,
     *   MEASURE?: int,
     *   XML_ID?: string,
     *   PREVIEW_PICTURE?: string,
     *   DETAIL_PICTURE?: string,
     *   DATE_CREATE?: string,
     *   TIMESTAMP_X?: string,
     *   MODIFIED_BY?: int,
     *   CREATED_BY?: int
     *   } $fields
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function update(int $id, array $fields): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.product.update',
                [
                    'id'     => $id,
                    'fields' => $fields,
                ]
            )
        );
    }

    /**
     * Count products by filter
     *
     * @param array{
     *   ID?: int,
     *   CATALOG_ID?: int,
     *   PRICE?: string,
     *   CURRENCY_ID?: string,
     *   NAME?: string,
     *   CODE?: string,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   ACTIVE?: string,
     *   SECTION_ID?: int,
     *   SORT?: int,
     *   VAT_ID?: int,
     *   VAT_INCLUDED?: string,
     *   MEASURE?: int,
     *   XML_ID?: string,
     *   PREVIEW_PICTURE?: string,
     *   DETAIL_PICTURE?: string,
     *   DATE_CREATE?: string,
     *   TIMESTAMP_X?: string,
     *   MODIFIED_BY?: int,
     *   CREATED_BY?: int
     *   } $filter
     *
     * @return int
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function countByFilter(array $filter = []): int
    {
        return $this->list([], $filter, ['ID'], 1)->getCoreResponse()->getResponseData()->getPagination()->getTotal();
    }
}