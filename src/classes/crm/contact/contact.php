<?php

namespace Bitrix24\CRM;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class contact extends Bitrix24Entity
{
    /**
     * Get list of contact items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_list.php
     *
     * @param array $order  - order of task items
     * @param array $filter - filter array
     * @param array $select - array of collumns to select
     * @param int   $start  - entity number to start from (usually returned in 'next' field of previous 'crm.contact.list' API call)
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function getList($order = [], $filter = [], $select = [], $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.contact.list',
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
     * Add a new contact to CRM.
     *
     * @param array $fields array of fields
     * @param array $params array of params
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_add.php
     *
     * @return array
     */
    public function add($fields = [], $params = [])
    {
        $fullResult = $this->client->call(
            'crm.contact.add',
            [
                'fields' => $fields,
                'params' => $params,
            ]
        );

        return $fullResult;
    }

    /**
     * Get contact by identifier.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_get.php
     *
     * @param int $bitrix24UserId contact identifier
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function get($bitrix24UserId)
    {
        $fullResult = $this->client->call(
            'crm.contact.get',
            ['id' => $bitrix24UserId]
        );

        return $fullResult;
    }

    /**
     * get list of contact fields with description.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_fields.php
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.contact.fields'
        );

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_update.php
     *
     * @param int   $contactId Specifies the contact ID
     * @param array $fields    An array in format array("field"=>"value"[, ...]) containing values for the fields that need to be updated.
     *                         The fields can be one or more of those returned by crm.contact.fields.
     * @param array $params    Set of parameters. REGISTER_SONET_EVENT - performs registration of a change event in a contact in the Activity Stream.
     *                         The contact's Responsible person will also receive notification.
     *
     * @return array
     */
    public function update($contactId, $fields = [], $params = [])
    {
        $fullResult = $this->client->call(
            'crm.contact.update',
            [
                'id'     => $contactId,
                'fields' => $fields,
                'params' => $params,
            ]
        );

        return $fullResult;
    }
}
