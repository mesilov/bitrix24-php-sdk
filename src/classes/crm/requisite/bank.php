<?php

namespace Bitrix24\CRM\Requisite;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Exceptions\Bitrix24Exception;

class Bank extends Bitrix24Entity
{
    /**
     * @param array $fields array of fields
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_bankdetail_add.php
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     */
    public function add($fields = array())
    {
        $fullResult = $this->client->call(
            'crm.requisite.bankdetail.add',
            array(
                'fields' => $fields,
            )
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_bankdetail_delete.php
     *
     * @param integer $id of bank requisite
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function delete($id)
    {
        $fullResult = $this->client->call(
            'crm.requisite.bankdetail.delete',
            array('id' => $id)
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_bankdetail_fields.php
     * @return array
     * @throws Bitrix24Exception
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.requisite.bankdetail.fields'
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_bankdetail_get.php
     *
     * @param integer $id of bank requisite
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function get($id)
    {
        $fullResult = $this->client->call(
            'crm.requisite.bankdetail.get',
            array('id' => $id)
        );
        return $fullResult;
    }


    /**
     * Get list of requisite items.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_bankdetail_list.php
     *
     * @param array   $order  - order of items
     * @param array   $filter - filter array
     * @param array   $select - array of collumns to select
     * @param integer $start  - entity number to start from (usually returned in 'next' field of previous
     *                        'crm.contact.list' API call)
     *
     * @return array
     * @throws Bitrix24Exception
     *
     */
    public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.requisite.bankdetail.list',
            array(
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $start
            )
        );
        return $fullResult;
    }


    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_bankdetail_update.php
     *
     * @param integer $id
     * @param array   $fields An array in format array("field"=>"value"[, ...]) containing values for the fields that
     *                        need to be updated. The fields can be one or more of those returned by
     *                        crm.requisite.bankdetail.fields
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     */
    public function update($id, $fields = array())
    {
        $fullResult = $this->client->call(
            'crm.requisite.bankdetail.update',
            array(
                'id'     => $id,
                'fields' => $fields,
            )
        );
        return $fullResult;
    }
}
