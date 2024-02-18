<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Catalog\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Catalog\Catalog\Result\CatalogResult;
use Bitrix24\SDK\Services\Catalog\Catalog\Result\CatalogsResult;

class Catalog extends AbstractService
{
    /**
     * The method gets field values of commercial catalog by ID.
     *
     * @param int $catalogId
     * @return CatalogResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_get.php
     */
    public function get(int $catalogId): CatalogResult
    {
        return new CatalogResult($this->core->call('catalog.catalog.get', ['id' => $catalogId]));
    }

    /**
     * The method gets field value of commercial catalog product by ID.
     *
     * @see https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_list.php
     * @param array $select
     * @param array $filter
     * @param array $order
     * @param int $start
     * @return CatalogsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function list(array $select, array $filter, array $order, int $start): CatalogsResult
    {
        return new CatalogsResult($this->core->call('catalog.catalog.list', [
            'select' => $select,
            'filter' => $filter,
            'order' => $order,
            'start' => $start
        ]));
    }

    /**
     * Retrieves the fields for the catalog.
     *
     * @return FieldsResult Returns an instance of FieldsResult.
     * @throws BaseException Throws a BaseException if there is an error in the core call.
     * @throws TransportException Throws a TransportException if there is an error in the transport process.
     * @see https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_getfields.php
     */
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('catalog.catalog.getFields'));
    }
}