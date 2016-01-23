<?php

namespace Bitrix24\CRM;

use Bitrix24\Bitrix24Entity;

class lead extends Bitrix24Entity
{
    /**
     * Get lead item by ID.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_get.php
     *
     * @param int $leadId - lead id
     *
     * @return array
     */
    public function get($leadId)
    {
        $fullResult = $this->client->call(
            'crm.lead.get',
            ['id' => $leadId]
        );

        return $fullResult;
    }

    /**
     * Get list of lead items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_list.php
     *
     * @param array $order  - order of task items
     * @param array $filter - filter array
     * @param array $select - array of collumns to select
     * @param int   $start  - entity number to start from (usually returned in 'next' field of previous 'crm.lead.list' API call)
     *
     * @return array
     */
    public function getList($order = [], $filter = [], $select = [], $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.lead.list',
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
     * Add a new lead to CRM.
     *
     * @param array $fields array of fields
     * @param array $params Set of parameters. REGISTER_SONET_EVENT - performs registration of a change event in a lead in the Activity Stream.
     *                      The lead's Responsible person will also receive notification.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_add.php
     *
     * @return array
     */
    public function add($fields = [], $params = [])
    {
        $fullResult = $this->client->call(
            'crm.lead.add',
            [
                'fields' => $fields,
                'params' => $params,
            ]
        );

        return $fullResult;
    }

    /**
     * get list of lead fields with description.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_fields.php
     *
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.lead.fields'
        );

        return $fullResult;
    }

    /**
     * @link https://training.bitrix24.com/rest_help/crm/leads/crm_lead_update.php
     *
     * @param int   $leadId Specifies the lead ID
     * @param array $fields An array in format array("field"=>"value"[, ...]) containing values for the fields that need to be updated.
     *                      The fields can be one or more of those returned by crm.lead.fields.
     * @param array $params Set of parameters. REGISTER_SONET_EVENT - performs registration of a change event in a lead in the Activity Stream.
     *                      The lead's Responsible person will also receive notification.
     *
     * @return array
     */
    public function update($leadId, $fields = [], $params = [])
    {
        $fullResult = $this->client->call(
            'crm.lead.update',
            [
                'id'     => $leadId,
                'fields' => $fields,
                'params' => $params,
            ]
        );

        return $fullResult;
    }

    /**
     * Deletes the specified lead and all the associated objects.
     *
     * @param int $leadId
     *
     * @return array
     */
    public function delete($leadId)
    {
        $fullResult = $this->client->call(
            'crm.lead.delete',
            ['id' => $leadId]
        );

        return $fullResult;
    }
}
