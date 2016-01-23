<?php

namespace Bitrix24\CRM\Contact;

use Bitrix24\Bitrix24Entity;

/**
 * Class UserField.
 */
class userfield extends Bitrix24Entity
{
    /**
     * Get list of user fields items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_userfield_list.php
     *
     * @param array $order  - order of task items
     * @param array $filter - filter array
     *
     * @return array
     */
    public function getList($order = [], $filter = [])
    {
        $fullResult = $this->client->call(
            'crm.contact.userfield.list',
            [
                'order'  => $order,
                'filter' => $filter,
            ]
        );

        return $fullResult;
    }

    /**
     * Get item userfield.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_userfield_get.php
     *
     * @param int $userfieldId - contact userfield id
     *
     * @return array
     */
    public function get($userfieldId)
    {
        $fullResult = $this->client->call(
            'crm.contact.userfield.get',
            ['id' => $userfieldId]
        );

        return $fullResult;
    }

    /**
     * Delete userfield.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_userfield_delete.php
     *
     * @param int $userfieldId - contact userfield id
     *
     * @return array
     */
    public function delete($userfieldId)
    {
        $fullResult = $this->client->call(
            'crm.contact.userfield.delete',
            ['id' => $userfieldId]
        );

        return $fullResult;
    }

    /**
     * Add a new userfield to contact.
     *
     * @param array $fields array of fields
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_userfield_add.php
     *
     * @return array
     */
    public function add($fields = [])
    {
        $fullResult = $this->client->call(
            'crm.contact.userfield.add',
            ['fields' => $fields]
        );

        return $fullResult;
    }
}
