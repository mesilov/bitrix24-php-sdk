<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;

class Product extends Bitrix24Entity
{

    /**
     * Get list of product items.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_list.php
     * @param array $order - order of items
     * @param array $filter - filter array
     * @param array $select - array of columns to select
     * @param integer $start - entity number to start from (usually returned in 'next' field of previous 'crm.product.list' API call)
     * @return array
     */
    public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.product.list',
            array(
                'order' => $order,
                'filter'=> $filter,
                'select'=> $select,
		'start' => $start
            )
        );
        return $fullResult;
    }

    /**
     * get product by id
     * @link http://dev.1c-bitrix.ru/rest_help/crm/products/crm_product_get.php
     * @param integer $productId - product item identifier
     * @return array
     */
    public function get($productId)
    {
        $fullResult = $this->client->call(
            'crm.product.get',
            array('id' => $productId)
        );
        return $fullResult;
    }

}


