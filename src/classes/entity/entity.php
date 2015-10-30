<?php
namespace Bitrix24\Entity;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class Entity
 * @package Bitrix24\Entity
 */
class Entity extends Bitrix24Entity
{
    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_add.php
     * @param $entity
     * @param $name
     * @param $access
     * @return array
     * @throws Bitrix24Exception
     */
    public function add($entity, $name, $access)
    {
        $fullResult = $this->client->call('entity.add', array(
            "ENTITY" => $entity,
            "NAME" => $name,
            "ACCESS" => $access
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_update.php
     * @param $entity
     * @param $name
     * @param $access
     * @return array
     * @throws Bitrix24Exception
     */
    public function update($entity, $name, $access)
    {
        $fullResult = $this->client->call('entity.update', array(
            "ENTITY" => $entity,
            "NAME" => $name,
            "ACCESS" => $access
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_rights.php
     * @param $entity
     * @param $access
     * @return array
     * @throws Bitrix24Exception
     */
    public function rights($entity, $access)
    {
        $result = $this->client->call('entity.rights', array(
            "ENTITY" => $entity,
            "ACCESS" => $access
        ));
        return $result;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_get.php
     * @param $entity
     * @return array
     * @throws Bitrix24Exception
     */
    public function get($entity)
    {
        $fullResult = $this->client->call('entity.get', array(
            "ENTITY" => $entity
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_delete.php
     * @param $entity
     * @return array
     * @throws Bitrix24Exception
     */
    public function delete($entity)
    {
        $fullResult = $this->client->call('entity.delete', array(
            "ENTITY" => $entity
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_add.php
     * @param $entity
     * @param $name
     * @param array $fields
     * @return array
     * @throws Bitrix24Exception
     */
    public function sectionAdd($entity, $name, $fields = array())
    {
        $arAdd = array(
            "ENTITY" => $entity,
            "NAME" => $name
        );
        $arAdd = array_merge($arAdd, $fields);
        $fullResult = $this->client->call('entity.section.add', $arAdd);
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_get.php
     * @param $entity
     * @param array $sort
     * @param array $filter
     * @return array
     * @throws Bitrix24Exception
     */
    public function sectionGet($entity, $sort = array(), $filter = array())
    {
        $fullResult = $this->client->call('entity.section.get', array(
            "ENTITY" => $entity,
            "SORT" => $sort,
            "FILTER" => $filter
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_update.php
     * @param $entity
     * @param $id
     * @param array $fields
     * @return array
     * @throws Bitrix24Exception
     */
    public function sectionUpdate($entity, $id, $fields = array())
    {
        $arUpdate = array(
            "ENTITY" => $entity,
            "ID" => $id
        );
        $arUpdate = array_merge($arUpdate, $fields);
        $fullResult = $this->client->call('entity.section.update', $arUpdate);
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_delete.php
     * @param $entity
     * @param $id
     * @return array
     * @throws Bitrix24Exception
     */
    public function sectionDelete($entity, $id)
    {
        $fullResult = $this->client->call('entity.section.delete', array(
            "ENTITY" => $entity,
            "ID" => $id
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_add.php
     * @param $entity
     * @param $name
     * @param array $fields
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemAdd($entity, $name, $fields = array())
    {
        $arAdd = array(
            "ENTITY" => $entity,
            "NAME" => $name
        );
        $arAdd = array_merge($arAdd, $fields);
        $fullResult = $this->client->call('entity.item.add', $arAdd);
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_get.php
     * @param $entity
     * @param array $sort
     * @param array $filter
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemGet($entity, $sort = array(), $filter = array())
    {
        $fullResult = $this->client->call('entity.item.get', array(
            "ENTITY" => $entity,
            "SORT" => $sort,
            "FILTER" => $filter
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_update.php
     * @param $entity
     * @param $id
     * @param array $fields
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemUpdate($entity, $id, $fields = array())
    {
        $arUpdate = array(
            "ENTITY" => $entity,
            "ID" => $id
        );
        $arUpdate = array_merge($arUpdate, $fields);
        $fullResult = $this->client->call('entity.item.update', $arUpdate);
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_delete.php
     * @param $entity
     * @param $id
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemDelete($entity, $id)
    {
        $fullResult = $this->client->call('entity.item.delete', array(
            "ENTITY" => $entity,
            "ID" => $id
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_get.php
     * @param $entity
     * @param $property
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemPropertyGet($entity, $property)
    {
        $fullResult = $this->client->call('entity.item.property.get', array(
            "ENTITY" => $entity,
            "PROPERTY" => $property
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_add.php
     * @param $entity
     * @param $property
     * @param $name
     * @param $type
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemPropertyAdd($entity, $property, $name, $type)
    {
        $fullResult = $this->client->call('entity.item.property.add', array(
            "ENTITY" => $entity,
            "PROPERTY" => $property,
            "NAME" => $name,
            "TYPE" => $type,

        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_update.php
     * @param $entity
     * @param $property
     * @param $property_new
     * @param $name
     * @param $type
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemPropertyUpdate($entity, $property, $property_new, $name, $type)
    {
        $fullResult = $this->client->call('entity.item.property.update', array(
            "ENTITY" => $entity,
            "PROPERTY" => $property,
            "PROPERTY_NEW" => $property_new,
            "NAME" => $name,
            "TYPE" => $type,
        ));
        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_delete.php
     * @param $entity
     * @param $property
     * @return array
     * @throws Bitrix24Exception
     */
    public function itemPropertyDelete($entity, $property)
    {
        $fullResult = $this->client->call('entity.item.property.delete', array(
            "ENTITY" => $entity,
            "PROPERTY" => $property
        ));
        return $fullResult;
    }
}