<?php

namespace Bitrix24\CRM\DealCategory;

use Bitrix24\Bitrix24Entity;

class DealCategory extends Bitrix24Entity
{
    /**
     * Get list of deal category fields with description
     *
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
     * Get list of deal categories.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_list.php
     * @param array $order - order of deal category items
     * @param array $filter - filter array
     * @param array $select - array of columns to select
     * @param integer $start - entity number to start from (usually returned in 'next' field of previous 'crm.dealcategory.list' API call)
     * @return array
     */
    public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.list',
            array(
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $start,
            )
        );

        return $fullResult;
    }
}
