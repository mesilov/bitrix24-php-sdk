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

namespace Bitrix24\SDK\Services\CRM\Activity\Service;

use Bitrix24\SDK\Attributes\ApiBatchServiceMetadata;
use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Activity\Result\ActivitiesResult;
use Bitrix24\SDK\Services\CRM\Activity\Result\ActivityResult;
use Psr\Log\LoggerInterface;

#[ApiServiceMetadata(new Scope(['crm']))]
class Activity extends AbstractService
{
    public Batch $batch;

    /**
     * Contact constructor.
     *
     * @param Batch $batch
     * @param CoreInterface $core
     * @param LoggerInterface $log
     */
    public function __construct(Batch $batch, CoreInterface $core, LoggerInterface $log)
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
    }

    /**
     * Creates and adds a new activity.
     *
     * @link https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_add.php
     *
     * @param array{
     *   ID?: int,
     *   OWNER_ID?: int,
     *   OWNER_TYPE_ID?: int,
     *   TYPE_ID?: int,
     *   PROVIDER_ID?: string,
     *   PROVIDER_TYPE_ID?: string,
     *   PROVIDER_GROUP_ID?: string,
     *   ASSOCIATED_ENTITY_ID?: int,
     *   SUBJECT?: string,
     *   START_TIME?: string,
     *   END_TIME?: string,
     *   DEADLINE?: string,
     *   COMPLETED?: string,
     *   STATUS?: string,
     *   RESPONSIBLE_ID?: string,
     *   PRIORITY?: string,
     *   NOTIFY_TYPE?: string,
     *   NOTIFY_VALUE?: int,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   DIRECTION?: string,
     *   LOCATION?: string,
     *   CREATED?: string,
     *   AUTHOR_ID?: string,
     *   LAST_UPDATED?: string,
     *   EDITOR_ID?: string,
     *   SETTINGS?: string,
     *   ORIGIN_ID?: string,
     *   ORIGINATOR_ID?: string,
     *   RESULT_STATUS?: int,
     *   RESULT_STREAM?: int,
     *   RESULT_SOURCE_ID?: string,
     *   PROVIDER_PARAMS?: string,
     *   PROVIDER_DATA?: string,
     *   RESULT_MARK?: int,
     *   RESULT_VALUE?: string,
     *   RESULT_SUM?: string,
     *   RESULT_CURRENCY_ID?: string,
     *   AUTOCOMPLETE_RULE?: int,
     *   BINDINGS?: string,
     *   COMMUNICATIONS?: string,
     *   FILES?: string,
     *   WEBDAV_ELEMENTS?: string,
     *   } $fields
     *
     * @return AddedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.activity.add',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_add.php',
        'Creates and adds a new activity.'
    )]
    public function add(array $fields): AddedItemResult
    {
        return new AddedItemResult(
            $this->core->call(
                'crm.activity.add',
                [
                    'fields' => $fields,
                ]
            )
        );
    }

    /**
     * Deletes the specified activity and all the associated objects.
     *
     * @link https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_delete.php
     *
     * @param int $itemId
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.activity.delete',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_delete.php',
        'Deletes the specified activity and all the associated objects.'
    )]
    public function delete(int $itemId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.activity.delete',
                [
                    'id' => $itemId,
                ]
            )
        );
    }

    /**
     * Returns the description of activity
     *
     * @link https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_fields.php
     *
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.activity.fields',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_fields.php',
        'Returns the description of activity fields'
    )]
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.activity.fields'));
    }

    /**
     * Returns activity by the specified activity ID
     *
     * @link https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_get.php
     *
     * @param int $entityId
     *
     * @return ActivityResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.activity.get',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_get.php',
        'Returns activity by the specified activity ID'
    )]
    public function get(int $entityId): ActivityResult
    {
        return new ActivityResult(
            $this->core->call(
                'crm.activity.get',
                [
                    'id' => $entityId,
                ]
            )
        );
    }

    /**
     * Returns a list of activity selected by the filter specified as the parameter. See the example for the filter notation.
     *
     * @link https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_list.php
     *
     * @param array{
     *   ID?: int,
     *   OWNER_ID?: int,
     *   OWNER_TYPE_ID?: string,
     *   TYPE_ID?: string,
     *   PROVIDER_ID?: string,
     *   PROVIDER_TYPE_ID?: string,
     *   PROVIDER_GROUP_ID?: string,
     *   ASSOCIATED_ENTITY_ID?: int,
     *   SUBJECT?: string,
     *   START_TIME?: string,
     *   END_TIME?: string,
     *   DEADLINE?: string,
     *   COMPLETED?: string,
     *   STATUS?: string,
     *   RESPONSIBLE_ID?: string,
     *   PRIORITY?: string,
     *   NOTIFY_TYPE?: string,
     *   NOTIFY_VALUE?: int,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   DIRECTION?: string,
     *   LOCATION?: string,
     *   CREATED?: string,
     *   AUTHOR_ID?: string,
     *   LAST_UPDATED?: string,
     *   EDITOR_ID?: string,
     *   SETTINGS?: string,
     *   ORIGIN_ID?: string,
     *   ORIGINATOR_ID?: string,
     *   RESULT_STATUS?: int,
     *   RESULT_STREAM?: int,
     *   RESULT_SOURCE_ID?: string,
     *   PROVIDER_PARAMS?: string,
     *   PROVIDER_DATA?: string,
     *   RESULT_MARK?: int,
     *   RESULT_VALUE?: string,
     *   RESULT_SUM?: string,
     *   RESULT_CURRENCY_ID?: string,
     *   AUTOCOMPLETE_RULE?: int,
     *   BINDINGS?: string,
     *   COMMUNICATIONS?: string,
     *   FILES?: string,
     *   WEBDAV_ELEMENTS?: string,
     *   } $order
     *
     * @param array{
     *   ID?: int,
     *   OWNER_ID?: int,
     *   OWNER_TYPE_ID?: string,
     *   TYPE_ID?: string,
     *   PROVIDER_ID?: string,
     *   PROVIDER_TYPE_ID?: string,
     *   PROVIDER_GROUP_ID?: string,
     *   ASSOCIATED_ENTITY_ID?: int,
     *   SUBJECT?: string,
     *   START_TIME?: string,
     *   END_TIME?: string,
     *   DEADLINE?: string,
     *   COMPLETED?: string,
     *   STATUS?: string,
     *   RESPONSIBLE_ID?: string,
     *   PRIORITY?: string,
     *   NOTIFY_TYPE?: string,
     *   NOTIFY_VALUE?: int,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   DIRECTION?: string,
     *   LOCATION?: string,
     *   CREATED?: string,
     *   AUTHOR_ID?: string,
     *   LAST_UPDATED?: string,
     *   EDITOR_ID?: string,
     *   SETTINGS?: string,
     *   ORIGIN_ID?: string,
     *   ORIGINATOR_ID?: string,
     *   RESULT_STATUS?: int,
     *   RESULT_STREAM?: int,
     *   RESULT_SOURCE_ID?: string,
     *   PROVIDER_PARAMS?: string,
     *   PROVIDER_DATA?: string,
     *   RESULT_MARK?: int,
     *   RESULT_VALUE?: string,
     *   RESULT_SUM?: string,
     *   RESULT_CURRENCY_ID?: string,
     *   AUTOCOMPLETE_RULE?: int,
     *   BINDINGS?: string,
     *   COMMUNICATIONS?: string,
     *   FILES?: string,
     *   WEBDAV_ELEMENTS?: string,
     *   } $filter
     *
     * @param array $select = ['ID','OWNER_ID','OWNER_TYPE_ID','TYPE_ID','PROVIDER_ID','PROVIDER_TYPE_ID','PROVIDER_GROUP_ID','ASSOCIATED_ENTITY_ID','SUBJECT','START_TIME','END_TIME','DEADLINE','COMPLETED','STATUS','RESPONSIBLE_ID','PRIORITY','NOTIFY_TYPE','NOTIFY_VALUE','DESCRIPTION','DESCRIPTION_TYPE','DIRECTION','LOCATION','CREATED','AUTHOR_ID','LAST_UPDATED','EDITOR_ID','SETTINGS','ORIGIN_ID','ORIGINATOR_ID','RESULT_STATUS','RESULT_STREAM','RESULT_SOURCE_ID','PROVIDER_PARAMS','PROVIDER_DATA','RESULT_MARK','RESULT_VALUE','RESULT_SUM','RESULT_CURRENCY_ID','AUTOCOMPLETE_RULE','BINDINGS','COMMUNICATIONS','FILES','WEBDAV_ELEMENTS','COMMUNICATIONS']
     * @param int $start
     *
     * @return ActivitiesResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.activity.list',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_list.php',
        'Returns a list of activity selected by the filter specified as the parameter. See the example for the filter notation.'
    )]
    public function list(array $order, array $filter, array $select, int $start): ActivitiesResult
    {
        return new ActivitiesResult(
            $this->core->call(
                'crm.activity.list',
                [
                    'order' => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start' => $start,
                ]
            )
        );
    }

    /**
     * Updates the specified (existing) activity.
     *
     * @see https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_update.php
     *
     * @param int $itemId
     * @param array{
     *   ID?: int,
     *   OWNER_ID?: int,
     *   OWNER_TYPE_ID?: string,
     *   TYPE_ID?: string,
     *   PROVIDER_ID?: string,
     *   PROVIDER_TYPE_ID?: string,
     *   PROVIDER_GROUP_ID?: string,
     *   ASSOCIATED_ENTITY_ID?: int,
     *   SUBJECT?: string,
     *   START_TIME?: string,
     *   END_TIME?: string,
     *   DEADLINE?: string,
     *   COMPLETED?: string,
     *   STATUS?: string,
     *   RESPONSIBLE_ID?: string,
     *   PRIORITY?: string,
     *   NOTIFY_TYPE?: string,
     *   NOTIFY_VALUE?: int,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   DIRECTION?: string,
     *   LOCATION?: string,
     *   CREATED?: string,
     *   AUTHOR_ID?: string,
     *   LAST_UPDATED?: string,
     *   EDITOR_ID?: string,
     *   SETTINGS?: string,
     *   ORIGIN_ID?: string,
     *   ORIGINATOR_ID?: string,
     *   RESULT_STATUS?: int,
     *   RESULT_STREAM?: int,
     *   RESULT_SOURCE_ID?: string,
     *   PROVIDER_PARAMS?: string,
     *   PROVIDER_DATA?: string,
     *   RESULT_MARK?: int,
     *   RESULT_VALUE?: string,
     *   RESULT_SUM?: string,
     *   RESULT_CURRENCY_ID?: string,
     *   AUTOCOMPLETE_RULE?: int,
     *   BINDINGS?: string,
     *   COMMUNICATIONS?: string,
     *   FILES?: string,
     *   WEBDAV_ELEMENTS?: string,
     *   } $fields
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.activity.update',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_update.php',
        'Updates the specified (existing) activity.'
    )]
    public function update(int $itemId, array $fields): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.activity.update',
                [
                    'id' => $itemId,
                    'fields' => $fields,
                ]
            )
        );
    }

    /**
     * Count activity by filter
     *
     * @param array{
     *   ID?: int,
     *   OWNER_ID?: int,
     *   OWNER_TYPE_ID?: string,
     *   TYPE_ID?: string,
     *   PROVIDER_ID?: string,
     *   PROVIDER_TYPE_ID?: string,
     *   PROVIDER_GROUP_ID?: string,
     *   ASSOCIATED_ENTITY_ID?: int,
     *   SUBJECT?: string,
     *   START_TIME?: string,
     *   END_TIME?: string,
     *   DEADLINE?: string,
     *   COMPLETED?: string,
     *   STATUS?: string,
     *   RESPONSIBLE_ID?: string,
     *   PRIORITY?: string,
     *   NOTIFY_TYPE?: string,
     *   NOTIFY_VALUE?: int,
     *   DESCRIPTION?: string,
     *   DESCRIPTION_TYPE?: string,
     *   DIRECTION?: string,
     *   LOCATION?: string,
     *   CREATED?: string,
     *   AUTHOR_ID?: string,
     *   LAST_UPDATED?: string,
     *   EDITOR_ID?: string,
     *   SETTINGS?: string,
     *   ORIGIN_ID?: string,
     *   ORIGINATOR_ID?: string,
     *   RESULT_STATUS?: int,
     *   RESULT_STREAM?: int,
     *   RESULT_SOURCE_ID?: string,
     *   PROVIDER_PARAMS?: string,
     *   PROVIDER_DATA?: string,
     *   RESULT_MARK?: int,
     *   RESULT_VALUE?: string,
     *   RESULT_SUM?: string,
     *   RESULT_CURRENCY_ID?: string,
     *   AUTOCOMPLETE_RULE?: int,
     *   BINDINGS?: string,
     *   COMMUNICATIONS?: string,
     *   FILES?: string,
     *   WEBDAV_ELEMENTS?: string,
     *   } $filter
     *
     * @return int
     * @throws BaseException
     * @throws TransportException
     */
    public function countByFilter(array $filter = []): int
    {
        return $this->list([], $filter, ['ID'], 1)->getCoreResponse()->getResponseData()->getPagination()->getTotal();
    }
}