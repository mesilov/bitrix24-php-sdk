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

use Bitrix24\SDK\Attributes\ApiBatchMethodMetadata;
use Bitrix24\SDK\Attributes\ApiBatchServiceMetadata;
use Bitrix24\SDK\Core\Contracts\DeletedItemResultInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AddedItemBatchResult;
use Bitrix24\SDK\Core\Result\DeletedItemBatchResult;
use Bitrix24\SDK\Services\AbstractBatchService;
use Bitrix24\SDK\Services\CRM\Activity\Result\ActivityItemResult;
use Generator;

#[ApiBatchServiceMetadata(new Scope(['crm']))]
class Batch extends AbstractBatchService
{
    /**
     * batch list method
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
     * @param array $select = ['ID','OWNER_ID','OWNER_TYPE_ID','TYPE_ID','PROVIDER_ID','PROVIDER_TYPE_ID','PROVIDER_GROUP_ID','ASSOCIATED_ENTITY_ID','SUBJECT','START_TIME','END_TIME','DEADLINE','COMPLETED','STATUS','RESPONSIBLE_ID','PRIORITY','NOTIFY_TYPE','NOTIFY_VALUE','DESCRIPTION','DESCRIPTION_TYPE','DIRECTION','LOCATION','CREATED','AUTHOR_ID','LAST_UPDATED','EDITOR_ID','SETTINGS','ORIGIN_ID','ORIGINATOR_ID','RESULT_STATUS','RESULT_STREAM','RESULT_SOURCE_ID','PROVIDER_PARAMS','PROVIDER_DATA','RESULT_MARK','RESULT_VALUE','RESULT_SUM','RESULT_CURRENCY_ID','AUTOCOMPLETE_RULE','BINDINGS','COMMUNICATIONS','FILES','WEBDAV_ELEMENTS','COMMUNICATIONS']
     * @param int|null $limit
     *
     * @return Generator<positive-int, ActivityItemResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.activity.list',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_list.php',
        'Returns in batch mode a list of activity'
    )]
    public function list(array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug(
            'list',
            [
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
                'limit' => $limit,
            ]
        );
        foreach ($this->batch->getTraversableList('crm.activity.list', $order, $filter, $select, $limit) as $key => $value) {
            yield $key => new ActivityItemResult($value);
        }
    }

    /**
     * Batch adding activity items
     *
     * @param array <int, array{
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
     *   }> $activities
     *
     * @return Generator<positive-int, AddedItemBatchResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.activity.add',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_add.php',
        'Adds in batch mode a new activity'
    )]
    public function add(array $activities): Generator
    {
        $items = [];
        foreach ($activities as $activity) {
            $items[] = [
                'fields' => $activity,
            ];
        }
        foreach ($this->batch->addEntityItems('crm.activity.add', $items) as $key => $item) {
            yield $key => new AddedItemBatchResult($item);
        }
    }

    /**
     * Batch delete activity items
     *
     * @param int[] $itemId
     *
     * @return Generator<positive-int, DeletedItemBatchResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.activity.delete',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_delete.php',
        'Delete in batch mode activity'
    )]
    public function delete(array $itemId): Generator
    {
        foreach ($this->batch->deleteEntityItems('crm.activity.delete', $itemId) as $key => $item) {
            yield $key => new DeletedItemBatchResult($item);
        }
    }
}