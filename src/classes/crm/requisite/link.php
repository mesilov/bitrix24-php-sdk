<?php

namespace Bitrix24\CRM\Requisite;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Exceptions\Bitrix24Exception;

class Link extends Bitrix24Entity
{
    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_link_fields.php
     * @return array
     * @throws Bitrix24Exception
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.requisite.link.fields'
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_link_fields.php
     *
     * @param $entityTypeId (@see https://dev.1c-bitrix.ru/rest_help/crm/auxiliary/enum/crm_enum_ownertype.php)
     * @param $entityId
     *
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
    public function get($entityTypeId, $entityId)
    {
        $fullResult = $this->client->call(
            'crm.requisite.link.get',
            array(
                'entityTypeId' => $entityTypeId,
                'entityId'     => $entityId,
            )
        );
        return $fullResult;
    }

    /**
     * Get list of requisite items.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_link_list.php
     *
     * @param array   $order  - order of items
     * @param array   $filter - filter array
     * @param integer $start  - entity number to start from (usually returned in 'next' field of previous
     *                        'crm.contact.list' API call)
     *
     * @return array
     * @throws Bitrix24Exception
     *
     */
    public function getList($order = array(), $filter = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.requisite.link.list',
            array(
                'order'  => $order,
                'filter' => $filter,
                'start'  => $start
            )
        );
        return $fullResult;
    }


    /**
     * Get list of requisite items.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_link_register.php
     *
     * @param $fields
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
    public function register($fields)
    {
        $fullResult = $this->client->call(
            'crm.requisite.link.register',
            array(
                'fields' => $fields,
            )
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_link_unregister.php
     *
     * @param $entityTypeId (@see https://dev.1c-bitrix.ru/rest_help/crm/auxiliary/enum/crm_enum_ownertype.php)
     * @param $entityId
     *
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
    public function unregister($entityTypeId, $entityId)
    {
        $fullResult = $this->client->call(
            'crm.requisite.link.get',
            array(
                'entityTypeId' => $entityTypeId,
                'entityId'     => $entityId,
            )
        );
        return $fullResult;
    }
}
