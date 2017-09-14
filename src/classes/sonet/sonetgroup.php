<?php
namespace Bitrix24\Sonet;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class SonetGroup extends  Bitrix24Entity
{
    /**
     * @param $order
     * @param $filter
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_get.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Get($order, $filter)
    {
        $result = $this->client->call('sonet_group.get',
            array(
                'ORDER' => $order,
                'FILTER'=> $filter,
            ));
        return $result;
    }

    /**
     * @param $name
     * @param $initiate_perms
     * @param $arFields
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_create.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Create($name, $initiate_perms, $arFields)
    {
        $result = $this->client->call('sonet_group.create',
            array_merge(
                array(
                    'NAME' => $name,
                    'INITIATE_PERMS' => $initiate_perms
                ),
                $arFields
            ));
        return $result;
    }

    /**
     * @param $group_id
     * @param $arFields
     * @link https://dev.1c-bitrix.ru/api_help/socialnetwork/classes/CSocNetGroup/Update.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Update($group_id, $arFields)
    {
        $result = $this->client->call('sonet_group.update',
            array_merge(
                array('GROUP_ID' => $group_id),
                $arFields
            ));
        return $result;
    }

    /**
     * @param $group_id
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_delete.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Delete($group_id)
    {
        $result = $this->client->call('sonet_group.delete',
            array(
                'GROUP_ID' => $group_id
            ));
        return $result;
    }

    /**
     * @param $group_id
     * @param $user_id
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_setowner.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function SetOwner($group_id, $user_id)
    {
        $result = $this->client->call('sonet_group.setowner',
            array(
                'GROUP_ID' => $group_id,
                'USER_ID'=> $user_id
            ));
        return $result;
    }

    /**
     * @param $id
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_user_get.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function UserGet($id)
    {
        $result = $this->client->call('sonet_group.user.get',
            array(
                'ID' => $id
            )
        );
        return $result;
    }

    /**
     * @param $group_id
     * @param $user_id
     * @param $message
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_user_invite.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Invate($group_id, $user_id, $message)
    {
        $result = $this->client->call('sonet_group.user.invite',
            array(
                'GROUP_ID' => $group_id,
                'USER_ID'=> $user_id,
                'MESSAGE'=> $message
            )
        );
        return $result;
    }

    /**
     * @param $group_id
     * @param $message
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_user_request.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Request($group_id, $message)
    {
        $result = $this->client->call('sonet_group.user.request',
            array(
                'GROUP_ID' => $group_id,
                'MESSAGE'=> $message
            )
        );
        return $result;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_user_groups.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function UserGroups()
    {
        $result= $this->client->call('sonet_group.user.groups');
        return $result;
    }

    /**
     * @param $group_id
     * @param $feature
     * @param $operation
     * @link https://dev.1c-bitrix.ru/rest_help/socialnetwork/sonet_group/sonet_group_feature_access.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function FeatureAccess($group_id, $feature, $operation)
    {
        $result = $this->client->call('sonet_group.feature.access',
            array(
                'GROUP_ID' => $group_id,
                'FEATURE' => $feature,
                'OPERATION' => $operation
            ));
        return $result;
    }
}