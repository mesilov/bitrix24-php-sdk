<?php

namespace Bitrix24\Bizproc;

use Bitrix24\Bitrix24Entity;

/**
 * Class Placement
 *
 * @package Bitrix24\Placement
 */
class Activity extends Bitrix24Entity
{
    /**
     * register new activity
     *
     * https://dev.1c-bitrix.ru/rest_help/bizproc/add.php
     *
     *
     * @param string  $code
     * @param string  $handler
     * @param integer $userId
     * @param string  $subscription
     * @param array   $arName
     * @param array   $arDescription
     * @param array   $arProps
     * @param array   $arReturnProps
     * @param array   $arDocType
     * @param array   $arFilter
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
    public function add(
        $code,
        $handler,
        $userId,
        $subscription,
        $arName,
        $arDescription,
        $arProps,
        $arReturnProps,
        $arDocType,
        $arFilter
    ) {
        $arResult = $this->client->call('bizproc.activity.add',
            array(
                'CODE'              => $code,
                'HANDLER'           => $handler,
                'AUTH_USER_ID'      => $userId,
                'USE_SUBSCRIPTION'  => $subscription,
                'NAME'              => $arName,
                'DESCRIPTION'       => $arDescription,
                'PROPERTIES'        => $arProps,
                'RETURN_PROPERTIES' => $arReturnProps,
                'DOCUMENT_TYPE'     => $arDocType,
                'FILTER'            => $arFilter,
            ));
        return $arResult['result'];
    }


    /**
     * get list of installed activities
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
    public function getList()
    {
        $arResult = $this->client->call('bizproc.activity.list',
            array()
        );
        return $arResult['result'];
    }

    /**
     * delete activity
     *
     * @param $code string
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
    public function delete($code)
    {
        $arResult = $this->client->call('bizproc.activity.delete',
            array(
                'code' => $code
            )
        );
        return $arResult['result'];
    }

}