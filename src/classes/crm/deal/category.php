<?php

namespace Bitrix24\CRM\Deal;

use Bitrix24\Bitrix24Entity;

class Category extends Bitrix24Entity
{
    /**
     * Add a new deal to CRM
     *
     * @param array $fields array of fields
     * @param array $params array of params
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
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_add.php
     */
    public function add($fields = array(), $params = array())
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.add',
            array(
                'fields' => $fields,
                'params' => $params
            )
        );
        return $fullResult;
    }

    /**
     * delete deal by id
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_delete.php
     * @var $id integer deal identifier
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
    public function delete($id)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.delete',
            array('id' => $id)
        );
        return $fullResult;
    }

    /**
     * get list of deal fields with description
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_fields.php
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
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.fields'
        );
        return $fullResult;
    }

    /**
     * get deal by id
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_get.php
     * @var $dealId integer deal identifier
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
    public function get($dealId)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.get',
            array('id' => $dealId)
        );
        return $fullResult;
    }

    /**
     * get default category
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_default_get.php
     * @var $dealId integer deal identifier
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
    public function getDefault()
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.default.get'
        );
        return $fullResult;
    }

    /**
     * update default category fields
     *
     * @param       $fields
     * @param array $params       Set of parameters. REGISTER_SONET_EVENT - performs registration of a change event in
     *                            a deal in the Activity Stream. The deals's Responsible person will also receive
     *                            notification.
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
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_default_set.php
     */
    public function setDefault($fields, $params = array())
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.default.set',
            array(
                'fields' => $fields,
                'params' => $params
            )
        );
        return $fullResult;
    }

    /**
     * Get list of deal items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_list.php
     *
     * @param array   $order  - order of deal items
     * @param array   $filter - filter array
     * @param array   $select - array of collumns to select
     * @param integer $start  - entity number to start from (usually returned in 'next' field of previous
     *                        'crm.dealcategory.list' API call)
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
    public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.list',
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
     * update deal by id
     *
     * @param integer $dealId     integer deal identifier
     * @param array   $dealFields array deal fields to update
     * @param array   $params     Set of parameters. REGISTER_SONET_EVENT - performs registration of a change event in
     *                            a deal in the Activity Stream. The deals's Responsible person will also receive
     *                            notification.
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
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_dealcategory_update.php
     */
    public function update($dealId, $dealFields, $params = array())
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.update',
            array(
                'id'     => $dealId,
                'fields' => $dealFields,
                'params' => $params
            )
        );
        return $fullResult;
    }
}
