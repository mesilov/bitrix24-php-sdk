<?php

namespace Bitrix24\Bizproc;

use Bitrix24\Bitrix24Entity;

/**
 * Class Robot
 *
 * @package Bitrix24\Placement
 */
class Robot extends Bitrix24Entity
{
    /**
     * add crm-robot
     *
     * @param string $code
     * @param string $handler
     * @param int    $userId
     * @param array  $arName
     * @param array  $arProps
     *
     * @return mixed
     *
     * @see https://dev.1c-bitrix.ru/rest_help/bizproc/bizproc_robot/robotadd.php
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
     */
    public function add($code, $handler, $userId, $arName, $arProps)
    {
        $arResult = $this->client->call('bizproc.robot.add',
            array(
                'CODE' => $code,
                'HANDLER' => $handler,
                'AUTH_USER_ID' => $userId,
                'NAME' => $arName,
                'PROPERTIES' => $arProps,
            ));

        return $arResult['result'];
    }

    /**
     * delete activity
     *
     * @param $code string
     *
     * @see https://dev.1c-bitrix.ru/rest_help/bizproc/bizproc_robot/robotdelete.php
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
        $arResult = $this->client->call('bizproc.robot.delete',
            array(
                'code' => $code,
            )
        );

        return $arResult['result'];
    }

    /**
     * get list of robots
     *
     * @see https://dev.1c-bitrix.ru/rest_help/bizproc/bizproc_robot/robotlist.php
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
        $arResult = $this->client->call('bizproc.robot.list',
            array()
        );

        return $arResult['result'];
    }
}