<?php

namespace Bitrix24\Bizproc;

use Bitrix24\Bitrix24Entity;

/**
 * Class provider
 *
 * @package Bitrix24\Placement
 */
class Provider extends Bitrix24Entity
{
    /**
     * add provider
     *
     * @param string $code
     * @param        $type
     * @param string $handler
     * @param        $arName
     * @param        $arDescription
     *
     * @return mixed
     *
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
     * @see https://dev.1c-bitrix.ru/rest_help/bizproc/bizproc_provider/provideradd.php
     *
     */
    public function add($code, $type, $handler, $arName, $arDescription)
    {
        $arResult = $this->client->call('bizproc.provider.add',
            array(
                'CODE'        => $code,
                'TYPE'        => $type,
                'HANDLER'     => $handler,
                'NAME'        => $arName,
                'DESCRIPTION' => $arDescription
            ));

        return $arResult['result'];
    }

    /**
     * delete provider
     *
     * @param $code string
     *
     * @see https://dev.1c-bitrix.ru/rest_help/bizproc/bizproc_provider/providerdelete.php
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
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
        $arResult = $this->client->call('bizproc.provider.delete',
            array(
                'code' => $code
            )
        );

        return $arResult['result'];
    }

    /**
     * get list of providers
     *
     * @see https://dev.1c-bitrix.ru/rest_help/bizproc/bizproc_provider/providerlist.php
     *
     * @return mixed
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
    public function getList()
    {
        $arResult = $this->client->call('bizproc.provider.list',
            array()
        );

        return $arResult['result'];
    }
}