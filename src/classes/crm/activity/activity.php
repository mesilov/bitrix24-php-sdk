<?php

namespace Bitrix24\CRM;

use Bitrix24\Bitrix24Entity;

class activity extends Bitrix24Entity
{
    /**
     * Add a new activity to CRM.
     *
     * @param array $fields - array of fields
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/rest_activity/crm_activity_add.php
     *
     * @return array
     */
    public function add($fields = [])
    {
        $fullResult = $this->client->call(
            'crm.activity.add',
            ['fields' => $fields]
        );

        return $fullResult;
    }

    /**
     * delete activity by id.
     *
     * @param int $entityId - activity identifier
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/rest_activity/crm_activity_delete.php
     *
     * @return array
     */
    public function delete($entityId)
    {
        $fullResult = $this->client->call(
            'crm.activity.delete',
            ['id' => $entityId]
        );

        return $fullResult;
    }

    /**
     * get list of activity fields with description.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/rest_activity/crm_activity_fields.php
     *
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.activity.fields'
        );

        return $fullResult;
    }

    /**
     * get activity by id.
     *
     * @param int $entityId - activity identifier
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/rest_activity/crm_activity_get.php
     *
     * @return array
     */
    public function get($entityId)
    {
        $fullResult = $this->client->call(
            'crm.activity.get',
            ['id' => $entityId]
        );

        return $fullResult;
    }

    /**
     * Get list of activity items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/rest_activity/crm_activity_list.php
     *
     * @param array $order  - sort order of items
     * @param array $filter - filter array
     * @param array $select - array of columns to select
     * @param int   $start  - entity number to start from (usually returned in 'next' field of previous 'crm.activity.list' API call)
     *
     * @return array
     */
    public function getList($order = [], $filter = [], $select = [], $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.activity.list',
            [
                'order'    => $order,
                'filter'   => $filter,
                'select'   => $select,
                'start'    => $start,
            ]
        );

        return $fullResult;
    }

    /**
     * update activity by id.
     *
     * @param $entityId integer - activity identifier
     * @param $fields array - activity fields to update
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/rest_activity/crm_activity_update.php
     *
     * @return array
     */
    public function update($entityId, $fields)
    {
        $fullResult = $this->client->call(
            'crm.activity.update',
            [
                'id'     => $entityId,
                'fields' => $fields,
            ]
        );

        return $fullResult;
    }
}
