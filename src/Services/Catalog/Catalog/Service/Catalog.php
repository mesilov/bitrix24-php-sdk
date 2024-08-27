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

namespace Bitrix24\SDK\Services\Catalog\Catalog\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Catalog\Catalog\Result\CatalogResult;
use Bitrix24\SDK\Services\Catalog\Catalog\Result\CatalogsResult;

#[ApiServiceMetadata(new Scope(['catalog']))]
class Catalog extends AbstractService
{
    /**
     * The method gets field values of commercial catalog by ID.
     *
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_get.php
     */
    #[ApiEndpointMetadata(
        'catalog.catalog.get',
        'https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_get.php',
        'The method gets field values of commercial catalog by ID.'
    )]
    public function get(int $catalogId): CatalogResult
    {
        return new CatalogResult($this->core->call('catalog.catalog.get', ['id' => $catalogId]));
    }

    /**
     * The method gets field value of commercial catalog product list
     *
     * @see https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_list.php
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'catalog.catalog.list',
        'https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_list.php',
        'The method gets field value of commercial catalog product list'
    )]
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
    #[ApiEndpointMetadata(
        'catalog.catalog.getFields',
        'https://training.bitrix24.com/rest_help/catalog/catalog/catalog_catalog_getfields.php',
        'Retrieves the fields for the catalog.'
    )]
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('catalog.catalog.getFields'));
    }
}