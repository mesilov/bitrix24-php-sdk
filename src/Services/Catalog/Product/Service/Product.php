<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Product\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Catalog\Common\ProductType;
use Bitrix24\SDK\Services\Catalog\Product\Result\ProductResult;
use Bitrix24\SDK\Services\Catalog\Product\Result\ProductsResult;

use Psr\Log\LoggerInterface;

class Product extends AbstractService
{
    public Batch $batch;

    public function __construct(
        Batch           $batch,
        CoreInterface   $core,
        LoggerInterface $log
    )
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
    }

    /**
     * The method gets field value of commercial catalog product by ID.
     *
     * @see https://training.bitrix24.com/rest_help/catalog/product/catalog_product_get.php
     * @throws TransportException
     * @throws BaseException
     */
    public function get(int $productId): ProductResult
    {
        return new ProductResult($this->core->call('catalog.product.get', ['id' => $productId]));
    }

    /**
     * The method adds a commercial catalog product.
     *
     * @see https://training.bitrix24.com/rest_help/catalog/product/catalog_product_add.php
     * @param array $productFields
     * @return ProductResult
     * @throws BaseException
     * @throws TransportException
     */
    public function add(array $productFields): ProductResult
    {
        return new ProductResult($this->core->call('catalog.product.add', [
                'fields' => $productFields
            ]
        ));
    }

    /**
     * The method deletes commercial catalog product.
     *
     * @see https://training.bitrix24.com/rest_help/catalog/product/catalog_product_delete.php
     * @param int $productId
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function delete(int $productId): DeletedItemResult
    {
        return new DeletedItemResult($this->core->call('catalog.product.delete', ['id' => $productId]));
    }

    /**
     * The method gets list of commercial catalog products by filter.
     *
     * @see https://training.bitrix24.com/rest_help/catalog/product/catalog_product_list.php
     * @throws TransportException
     * @throws BaseException
     */
    public function list(array $select, array $filter, array $order, int $start): ProductsResult
    {
        return new ProductsResult($this->core->call('catalog.product.list', [
            'select' => $select,
            'filter' => $filter,
            'order' => $order,
            'start' => $start
        ]));
    }

    /**
     * The method returns commercial catalog product fields by filter.
     * @see https://training.bitrix24.com/rest_help/catalog/product/catalog_product_getfieldsbyfilter.php
     *
     * @param int $iblockId
     * @param ProductType $productType
     * @param array|null $additionalFilter
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function fieldsByFilter(int $iblockId, ProductType $productType, ?array $additionalFilter = null): FieldsResult
    {
        $filter = [
            'iblockId' => $iblockId,
            'productType' => $productType->value
        ];
        if ($additionalFilter !== null) {
            $filter = array_merge($filter, $additionalFilter);
        }

        return new FieldsResult($this->core->call('catalog.product.getFieldsByFilter', ['filter' => $filter]));
    }
}