<?php

namespace Bitrix24\User;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class user extends Bitrix24Entity
{
    /**
     * Check is current user admin.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/general/user_admin.php
     *
     * @throws Bitrix24Exception
     *
     * @return bool
     */
    public function admin()
    {
        $result = $this->client->call('user.admin');

        return $result['result'];
    }

    /**
     * Get information about current user by his auth information. This method will be use security sign automatically.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/users/user_current.php
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function current()
    {
        $result = $this->client->call('user.current', ['state' => $this->client->getSecuritySignSalt()]);

        return $result;
    }

    /**
     * Get list of fields entity user.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/users/user_fields.php
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function fields()
    {
        $result = $this->client->call('user.fields');

        return $result;
    }

    /**
     * Get list of users.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/users/user_get.php
     *
     * @param $SORT - field name to sort by them
     * @param $ORDER - sort direction? must be set to ASC or DESC
     * @param $FILTER - list of fields user entity to filter result
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function get($SORT, $ORDER, $FILTER)
    {
        $result = $this->client->call('user.get',
            [
                'SORT'   => $SORT,
                'ORDER'  => $ORDER,
                'FILTER' => $FILTER, ]
        );

        return $result;
    }

    /**
     * Check if current user has any of access rights specified by $access param.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/general/user_access.php
     *
     * @param array $access - list of access rights to check
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function access($access)
    {
        $result = $this->client->call('user.access',
            [
                'ACCESS' => $access,
            ]
        );

        return $result;
    }
}
