<?php

namespace Bitrix24\Entity;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class Entity.
 */
class entity extends Bitrix24Entity
{
    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_add.php
     *
     * @param $entity
     * @param $name
     * @param $access
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function add($entity, $name, $access)
    {
        $fullResult = $this->client->call('entity.add', [
            'ENTITY' => $entity,
            'NAME'   => $name,
            'ACCESS' => $access,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_update.php
     *
     * @param $entity
     * @param $name
     * @param $access
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function update($entity, $name, $access)
    {
        $fullResult = $this->client->call('entity.update', [
            'ENTITY' => $entity,
            'NAME'   => $name,
            'ACCESS' => $access,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_rights.php
     *
     * @param $entity
     * @param $access
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function rights($entity, $access)
    {
        $result = $this->client->call('entity.rights', [
            'ENTITY' => $entity,
            'ACCESS' => $access,
        ]);

        return $result;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_get.php
     *
     * @param $entity
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function get($entity)
    {
        $fullResult = $this->client->call('entity.get', [
            'ENTITY' => $entity,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_delete.php
     *
     * @param $entity
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function delete($entity)
    {
        $fullResult = $this->client->call('entity.delete', [
            'ENTITY' => $entity,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_add.php
     *
     * @param $entity
     * @param $name
     * @param array $fields
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function sectionAdd($entity, $name, $fields = [])
    {
        $arAdd = [
            'ENTITY' => $entity,
            'NAME'   => $name,
        ];
        $arAdd = array_merge($arAdd, $fields);
        $fullResult = $this->client->call('entity.section.add', $arAdd);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_get.php
     *
     * @param $entity
     * @param array $sort
     * @param array $filter
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function sectionGet($entity, $sort = [], $filter = [])
    {
        $fullResult = $this->client->call('entity.section.get', [
            'ENTITY' => $entity,
            'SORT'   => $sort,
            'FILTER' => $filter,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_update.php
     *
     * @param $entity
     * @param $id
     * @param array $fields
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function sectionUpdate($entity, $id, $fields = [])
    {
        $arUpdate = [
            'ENTITY' => $entity,
            'ID'     => $id,
        ];
        $arUpdate = array_merge($arUpdate, $fields);
        $fullResult = $this->client->call('entity.section.update', $arUpdate);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_section_delete.php
     *
     * @param $entity
     * @param $id
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function sectionDelete($entity, $id)
    {
        $fullResult = $this->client->call('entity.section.delete', [
            'ENTITY' => $entity,
            'ID'     => $id,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_add.php
     *
     * @param $entity
     * @param $name
     * @param array $fields
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemAdd($entity, $name, $fields = [])
    {
        $arAdd = [
            'ENTITY' => $entity,
            'NAME'   => $name,
        ];
        $arAdd = array_merge($arAdd, $fields);
        $fullResult = $this->client->call('entity.item.add', $arAdd);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_get.php
     *
     * @param $entity
     * @param array $sort
     * @param array $filter
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemGet($entity, $sort = [], $filter = [])
    {
        $fullResult = $this->client->call('entity.item.get', [
            'ENTITY' => $entity,
            'SORT'   => $sort,
            'FILTER' => $filter,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_update.php
     *
     * @param $entity
     * @param $id
     * @param array $fields
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemUpdate($entity, $id, $fields = [])
    {
        $arUpdate = [
            'ENTITY' => $entity,
            'ID'     => $id,
        ];
        $arUpdate = array_merge($arUpdate, $fields);
        $fullResult = $this->client->call('entity.item.update', $arUpdate);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_delete.php
     *
     * @param $entity
     * @param $id
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemDelete($entity, $id)
    {
        $fullResult = $this->client->call('entity.item.delete', [
            'ENTITY' => $entity,
            'ID'     => $id,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_get.php
     *
     * @param $entity
     * @param $property
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemPropertyGet($entity, $property)
    {
        $fullResult = $this->client->call('entity.item.property.get', [
            'ENTITY'   => $entity,
            'PROPERTY' => $property,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_add.php
     *
     * @param $entity
     * @param $property
     * @param $name
     * @param $type
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemPropertyAdd($entity, $property, $name, $type)
    {
        $fullResult = $this->client->call('entity.item.property.add', [
            'ENTITY'   => $entity,
            'PROPERTY' => $property,
            'NAME'     => $name,
            'TYPE'     => $type,

        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_update.php
     *
     * @param $entity
     * @param $property
     * @param $property_new
     * @param $name
     * @param $type
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemPropertyUpdate($entity, $property, $property_new, $name, $type)
    {
        $fullResult = $this->client->call('entity.item.property.update', [
            'ENTITY'       => $entity,
            'PROPERTY'     => $property,
            'PROPERTY_NEW' => $property_new,
            'NAME'         => $name,
            'TYPE'         => $type,
        ]);

        return $fullResult;
    }

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/entity/entity_item_property_delete.php
     *
     * @param $entity
     * @param $property
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function itemPropertyDelete($entity, $property)
    {
        $fullResult = $this->client->call('entity.item.property.delete', [
            'ENTITY'   => $entity,
            'PROPERTY' => $property,
        ]);

        return $fullResult;
    }
}
