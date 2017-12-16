<?php

namespace Bitrix24\CRM\Quote;
use Bitrix24\Bitrix24Entity;

/**
 * Class UserField
 *
 * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/index.php
 *
 * @package Bitrix24\CRM\Quote
 */
class UserField extends Bitrix24Entity
{
    /**
     * Get list of quote user fields items.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_userfield_list.php
     *
     * @param array $order - order of quote items
     * @param array $filter - filter array
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
            'crm.quote.userfield.list',
            array(
                'order' => $order,
                'filter'=> $filter
            )
        );
        return $fullResult;
    }

    /**
     * Get item userfield
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_userfield_get.php
     * @param integer $userfieldId - deal userfield id
     * @return array
     */

    /**
     * Get quote user field by ID
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_userfield_get.php
     *
     * @param integer $userFieldId - quote user field ID
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
    public function get($userFieldId)
    {
        $fullResult = $this->client->call(
            'crm.quote.userfield.get',
            array('id' => $userFieldId)
        );
        return $fullResult;
    }

    /**
     * Delete quote user field by ID.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_userfield_delete.php
     *
     * @param integer $userFieldId - quote user field ID
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
    public function delete($userFieldId)
    {
        $fullResult = $this->client->call(
            'crm.quote.userfield.delete',
            array('id' => $userFieldId)
        );
        return $fullResult;
    }

    /**
     * Add new user field to quote.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_userfield_add.php
     *
     * @param array $fields - array of fields
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
    public function add($fields = array())
    {
        $fullResult = $this->client->call(
            'crm.quote.userfield.add',
            array('fields' => $fields)
        );
        return $fullResult;
    }

    /**
     * Update quote item user field.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_userfield_update.php
     *
     * @param integer $userFieldId - quote user field ID
     * @param array $fields - array of fields
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
    public function update($userFieldId, $fields = array())
    {
        $fullResult = $this->client->call(
            'crm.quote.userfield.update',
            array(
                'id' => $userFieldId,
                'fields' => $fields,
            )
        );

        return $fullResult;
    }
}
