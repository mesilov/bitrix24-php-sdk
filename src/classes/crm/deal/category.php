<?php

namespace Bitrix24\CRM\Deal;

use Bitrix24\Bitrix24Entity;

/**
 * Class Category
 */
class Category extends Bitrix24Entity
{
    /**
     * Add new category
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_list.php
     * @param array $fields https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_fields.php
     * @return array
     */
    public function add($fields)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.add',
            array(
                'fields' => $fields
            )
        );
        return $fullResult;
    }

    /**
     * Get the settings of the general category
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_default_get.php
     * @return array
     */
    public function defaultGet()
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.default.get'
        );
        return $fullResult;
    }

    /**
     * Set the settings of the general category
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_default_set.php
     * @param string $name category
     * @return array
     */
    public function defaultSet($name)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.default.set',
            array('name' => $name)
        );
        return $fullResult;
    }

    /**
     * Delete category by id
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_delete.php
     * @param integer $categoryId integer
     * @return array
     */
    public function delete($categoryId)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.delete',
            array('id' => $categoryId)
        );
        return $fullResult;
    }

    /**
     * Get the list of categories fields
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_fields.php
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.fields'
        );
        return $fullResult;
    }

    /**
     * Get deal category by id
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_get.php
     * @param integer $categoryId integer
     * @return array
     */
    public function get($categoryId)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.get',
            array('id' => $categoryId)
        );
        return $fullResult;
    }

    /**
     * Get list of deal categories.
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_list.php
     * @param array $order - order of category items
     * @param array $filter - filter array
     * @param array $select array of columns to select
     * @return array
     */
    public function getList($order = array(), $filter = array(), $select = array())
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.list',
            array(
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
            )
        );
        return $fullResult;
    }

    /**
     * Get deal stage list
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_stage_list.php
     * @param integer $categoryId integer
     * @return array
     */
    public function getStageList($categoryId)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.stage.list',
            array('id' => $categoryId)
        );
        return $fullResult;
    }

    /**
     * Get category status
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_status.php
     * @param integer $categoryId integer
     * @return array
     */
    public function status($categoryId)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.status',
            array('id' => $categoryId)
        );
        return $fullResult;
    }

    /**
     * Update deal category by id
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_update.php
     * @param integer $categoryId integer
     * @param array $fields - order of category fields https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_fields.php
     * @return array
     */
    public function update($categoryId, $fields)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.update',
            array(
                'id' => $categoryId,
                'fields' => $fields
            )
        );
        return $fullResult;
    }
}
