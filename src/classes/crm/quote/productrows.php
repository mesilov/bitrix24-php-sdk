<?php

namespace Bitrix24\CRM\Quote;
use Bitrix24\Bitrix24Entity;

/**
 * Class ProductRows
 */
class ProductRows extends Bitrix24Entity
{
    /**
     * Get list of quote products.
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_productrows_get.php
     * @param int $id - quote id
     * @return array
     */
    public function get($id)
    {
        $fullResult = $this->client->call(
            'crm.quote.productrows.get',
            array(
                'id' => $id
            )
        );
        return $fullResult;
    }

    /**
     * Set quote products.
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_productrows_set.php
     * @param int $id - quote id
     * @param array $rows - products data
     * @return array
     */
    public function set($id, $rows)
    {
        $fullResult = $this->client->call(
            'crm.quote.productrows.set',
            array(
                'id' => $id,
                'rows' => $rows
            )
        );
        return $fullResult;
    }
}
