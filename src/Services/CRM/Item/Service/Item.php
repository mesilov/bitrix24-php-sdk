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

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Item\Result\ItemResult;
use Bitrix24\SDK\Services\CRM\Item\Result\ItemsResult;
use Psr\Log\LoggerInterface;

#[ApiServiceMetadata(new Scope(['crm']))]
class Item extends AbstractService
{
    public Batch $batch;

    public function __construct(Batch $batch, CoreInterface $core, LoggerInterface $log)
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
    }

    /**
     * Method creates new SPA item with entityTypeId.
     *
     * @link https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_add.php
     *
     *
     * @param int $entityTypeId
     * @param array $fields
     * @return ItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.item.add',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_add.php',
        'Method creates new SPA item with entityTypeId.'
    )]
    public function add(int $entityTypeId, array $fields): ItemResult
    {
        return new ItemResult(
            $this->core->call(
                'crm.item.add',
                [
                    'entityTypeId' => $entityTypeId,
                    'fields' => $fields,
                ]
            )
        );
    }

    /**
     * Deletes item with id for SPA with entityTypeId.
     *
     * @link https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_delete.php
     *
     * @param int $entityTypeId
     * @param int $id
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.item.delete',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_delete.php',
        'Deletes item with id for SPA with entityTypeId.'
    )]
    public function delete(int $entityTypeId, int $id): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.item.delete', ['entityTypeId' => $entityTypeId, 'id' => $id]
            )
        );
    }

    /**
     * Returns the fields data with entityTypeId.
     *
     * @link https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_fields.php
     *
     * @param int $entityTypeId
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.item.fields',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_fields.php',
        'Returns the fields data with entityTypeId.'
    )]
    public function fields(int $entityTypeId): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.item.fields', ['entityTypeId' => $entityTypeId]));
    }

    /**
     * Returns item data with id for SPA with entityTypeId.
     *
     * @link https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_get.php
     *
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.item.get',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_get.php',
        'Returns item data with id for SPA with entityTypeId.'
    )]
    public function get(int $entityTypeId, int $id): ItemResult
    {
        return new ItemResult($this->core->call('crm.item.get', ['entityTypeId' => $entityTypeId, 'id' => $id]));
    }

    /**
     * Returns array with SPA items with entityTypeId
     *
     * @link https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_list.php
     *
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.item.list',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_list.php',
        'Returns array with SPA items with entityTypeId'
    )]
    public function list(int $entityTypeId, array $order, array $filter, array $select, int $startItem = 0): ItemsResult
    {
        return new ItemsResult(
            $this->core->call(
                'crm.item.list',
                [
                    'entityTypeId' => $entityTypeId,
                    'order' => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start' => $startItem,
                ]
            )
        );
    }

    /**
     * Updates the specified (existing) item.
     *
     * @link https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_update.php
     *
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.item.update',
        'https://training.bitrix24.com/rest_help/crm/dynamic/methodscrmitem/crm_item_update.php',
        'Updates the specified (existing) item.'
    )]
    public function update(int $entityTypeId, int $id, array $fields): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.item.update',
                [
                    'entityTypeId' => $entityTypeId,
                    'id' => $id,
                    'fields' => $fields,
                ]
            )
        );
    }

    /**
     * Count by filter
     *
     * @throws BaseException
     * @throws TransportException
     */
    public function countByFilter(int $entityTypeId, array $filter = []): int
    {
        return $this->list($entityTypeId, [], $filter, ['id'], 1)->getCoreResponse()->getResponseData()->getPagination()->getTotal();
    }
}