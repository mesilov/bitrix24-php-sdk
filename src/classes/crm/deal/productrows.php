<?php

namespace Bitrix24\CRM\Deal;
use Bitrix24\Bitrix24Entity;

/**
 * Class ProductRows
 */
class ProductRows extends Bitrix24Entity
{
    /**
     * Get list of deal products.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_productrows_get.php
     * @param int $id - deal id
     * @return array
     */
    public function get($id)
    {
        $fullResult = $this->client->call(
            'crm.deal.productrows.get',
            array(
                'id' => $id
            )
        );
        return $fullResult;
    }

    /**
     * Set deal products.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_productrows_set.php
     * @param int $id - deal id
     * @param array $rows - products data
     * @return array
     */
    public function set($id, $rows)
    {
        $fullResult = $this->client->call(
            'crm.deal.productrows.set',
            array(
                'id' => $id,
                'rows' => $rows
            )
        );
        return $fullResult;
    }
}
