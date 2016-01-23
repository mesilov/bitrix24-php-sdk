<?php

namespace Bitrix24\CRM\Deal;

use Bitrix24\Bitrix24Entity;

class deal extends Bitrix24Entity
{
    /**
     * Add a new deal to CRM.
     *
     * @param array $fields array of fields
     * @param array $params array of params
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_add.php
     *
     * @return array
     */
    public function add($fields = [], $params = [])
    {
        $fullResult = $this->client->call(
            'crm.deal.add',
            [
                'fields' => $fields,
                'params' => $params,
            ]
        );

        return $fullResult;
    }

    /**
     * delete deal by id.
     *
     * @var integer deal identifier
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_delete.php
     *
     * @return array
     */
    public function delete($dealId)
    {
        $fullResult = $this->client->call(
            'crm.deal.delete',
            ['id' => $dealId]
        );

        return $fullResult;
    }

    /**
     * get list of deal fields with description.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_fields.php
     *
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.deal.fields'
        );

        return $fullResult;
    }

    /**
     * get deal by id.
     *
     * @var integer deal identifier
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_get.php
     *
     * @return array
     */
    public function get($dealId)
    {
        $fullResult = $this->client->call(
            'crm.deal.get',
            ['id' => $dealId]
        );

        return $fullResult;
    }

    /**
     * Get list of deal items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_list.php
     *
     * @param array $order  - order of deal items
     * @param array $filter - filter array
     * @param array $select - array of collumns to select
     * @param int   $start  - entity number to start from (usually returned in 'next' field of previous 'crm.deal.list' API call)
     *
     * @return array
     */
    public function getList($order = [], $filter = [], $select = [], $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.deal.list',
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
     * update deal by id.
     *
     * @var integer     deal identifier
     * @var $dealFields array deal fields to update
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_update.php
     *
     * @return array
     */
    public function update($dealId, $dealFields)
    {
        $fullResult = $this->client->call(
            'crm.deal.update',
            [
                'id'     => $dealId,
                'fields' => $dealFields,
            ]
        );

        return $fullResult;
    }
}
