<?php

namespace Bitrix24\CRM\Deal;

use Bitrix24\Bitrix24Entity;

/**
 * Class UserField
 */
class UserField extends Bitrix24Entity
{
    /**
     * Get list of user fields items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_userfield_list.php
     *
     * @param array $order - order of task items
     * @param array $filter - filter array
     *
     * @return array
     */
    public function getList($order = array(), $filter = array())
    {
        $fullResult = $this->client->call(
            'crm.deal.userfield.list',
            array(
                'order' => $order,
                'filter' => $filter,
            )
        );

        return $fullResult;
    }

    /**
     * Get item userfield
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_userfield_get.php
     *
     * @param integer $userfieldId - deal userfield id
     *
     * @return array
     */
    public function get($userfieldId)
    {
        $fullResult = $this->client->call(
            'crm.deal.userfield.get',
            array('id' => $userfieldId)
        );

        return $fullResult;
    }

    /**
     * Delete userfield
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_userfield_delete.php
     *
     * @param integer $userfieldId - deal userfield id
     *
     * @return array
     */
    public function delete($userfieldId)
    {
        $fullResult = $this->client->call(
            'crm.deal.userfield.delete',
            array('id' => $userfieldId)
        );

        return $fullResult;
    }

    /**
     * Add a new userfield to deal
     *
     * @param array $fields array of fields
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_userfield_add.php
     * @return array
     */
    public function add($fields = array())
    {
        $fullResult = $this->client->call(
            'crm.deal.userfield.add',
            array('fields' => $fields)
        );

        return $fullResult;
    }

    /**
     * Add a new userfield to deal
     *
     * @param int $userfieldId deal userfield id
     * @param array $fields array of fields
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_userfield_update.php
     * @return array
     */
    public function update($userfieldId, $fields = array())
    {
        $fullResult = $this->client->call(
            'crm.deal.userfield.update',
            array(
                'id' => $userfieldId,
                'fields' => $fields,
            )
        );

        return $fullResult;
    }
}