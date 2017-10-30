<?php

namespace Bitrix24\CRM\Product;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Exceptions\Bitrix24Exception;

/**
 * Class Property
 *
 * @package Bitrix24\CRM\Product
 */
class Property extends Bitrix24Entity
{
    /**
     * get product property by id
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_property_get.php
     *
     * @param integer $productPropertyId - product property identifier
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function get($productPropertyId)
    {
        $fullResult = $this->client->call(
            'crm.product.property.get',
            array('id' => $productPropertyId)
        );

        return $fullResult;
    }

    /**
     * delete product property by id
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_property_delete.php
     *
     * @param integer $productPropertyId - product property identifier
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function delete($productPropertyId)
    {
        $fullResult = $this->client->call(
            'crm.product.property.delete',
            array('id' => $productPropertyId)
        );

        return $fullResult;
    }

    /**
     * get product property list
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_property_list.php
     *
     * @param array $order
     * @param array $filter
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function getList($order = array(), $filter = array())
    {
        $fullResult = $this->client->call(
            'crm.product.property.list',
            array(
                'order' => $order,
                'filter' => $filter,
            )
        );

        return $fullResult;
    }

    /**
     * add product property
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_property_list.php
     *
     * @param array $fields
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function add(array $fields)
    {
        $fullResult = $this->client->call(
            'crm.product.property.add',
            array(
                'fields' => $fields,
            )
        );

        return $fullResult;
    }

    /**
     * update product property
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_property_update.php
     *
     * @param int $productPropertyId
     * @param array $fields
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function update($productPropertyId, array $fields)
    {
        $fullResult = $this->client->call(
            'crm.product.property.add',
            array(
                'id' => $productPropertyId,
                'fields' => $fields,
            )
        );

        return $fullResult;
    }

    /**
     * get property types
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_property_types.php
     * @return array
     * @throws Bitrix24Exception
     */
    public function getTypes()
    {
        return $this->client->call('crm.product.property.types');
    }
}