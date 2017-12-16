<?php
namespace Bitrix24\CRM\Company;

use Bitrix24\Bitrix24Entity;

/**
 * Class UserField
 * @package Bitrix24\CRM\Company
 */
class UserField extends Bitrix24Entity
{
    /**
     * Get list of company user fields.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/company/crm_company_userfield_list.php
     *
     * @param array $order - order of companies
     * @param array $filter - filter of companies
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
            'crm.company.userfield.list',
            array(
                'order' => $order,
                'filter' => $filter,
            )
        );

        return $fullResult;
    }

    /**
     * @param integer $userFieldId - company user field identifier
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/company/crm_company_userfield_get.php
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
    public function get($userFieldId)
    {
        $fullResult = $this->client->call(
            'crm.company.userfield.get',
            array('id' => $userFieldId)
        );

        return $fullResult;
    }

    /**
     * Delete company user field.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/company/crm_company_userfield_delete.php
     *
     * @param integer $userFieldId - company user field
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
            'crm.company.userfield.delete',
            array('id' => $userFieldId)
        );

        return $fullResult;
    }

    /**
     * Add new user field to company.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/company/crm_company_userfield_add.php
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
            'crm.company.userfield.add',
            array('fields' => $fields)
        );

        return $fullResult;
    }

    /**
     * Update company user field.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/company/crm_company_userfield_update.php
     *
     * @param integer $userFieldId - company user field
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
            'crm.company.userfield.update',
            array(
                'id' => $userFieldId,
                'fields' => $fields,
            )
        );

        return $fullResult;
    }
}