<?php

namespace Bitrix24\CRM\Invoice;

use Bitrix24\Bitrix24Entity;

/**
 * Class UserField
 */
class UserField extends Bitrix24Entity
{
    /**
     * Get list of user fields items.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_userfield_list.php
     *
     * @param array $order  - order of task items
     * @param array $filter - filter array
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     */
    public function getList($order = array(), $filter = array())
    {
        $fullResult = $this->client->call(
            'crm.invoice.userfield.list',
            array(
                'order'  => $order,
                'filter' => $filter,
            )
        );

        return $fullResult;
    }

    /**
     * Get item userfield
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_userfield_get.php
     *
     * @param integer $userfieldId - invoice userfield id
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     */
    public function get($userfieldId)
    {
        $fullResult = $this->client->call(
            'crm.invoice.userfield.get',
            array('id' => $userfieldId)
        );

        return $fullResult;
    }

    /**
     * Delete userfield
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_userfield_delete.php
     *
     * @param integer $userfieldId - invoice userfield id
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     */
    public function delete($userfieldId)
    {
        $fullResult = $this->client->call(
            'crm.invoice.userfield.delete',
            array('id' => $userfieldId)
        );

        return $fullResult;
    }

    /**
     * Add a new userfield to invoice
     *
     * @param array $fields array of fields
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @link https://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_userfield_add.php
     */
    public function add($fields = array())
    {
        $fullResult = $this->client->call(
            'crm.invoice.userfield.add',
            array('fields' => $fields)
        );

        return $fullResult;
    }

    /**
     * Update a new userfield to invoice
     *
     * @param int   $userfieldId invoice userfield id
     * @param array $fields      array of fields
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @link https://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_userfield_update.php
     */
    public function update($userfieldId, $fields = array())
    {
        $fullResult = $this->client->call(
            'crm.invoice.userfield.update',
            array(
                'id'     => $userfieldId,
                'fields' => $fields,
            )
        );

        return $fullResult;
    }
}