<?php
namespace Bitrix24\CRM\Lead;
use Bitrix24\Bitrix24Entity;

/**
 * Class ProductRows
 */
class ProductRows extends Bitrix24Entity
{
    /**
     * Get list of lead products.
     * @link https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_productrows_get.php
     * @param int $id - lead id
     * @return array
     */
    public function get($id)
    {
        $fullResult = $this->client->call(
            'crm.lead.productrows.get',
            array(
                'id' => $id
            )
        );
        return $fullResult;
    }

    /**
     * Set lead products.
     * @link https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_productrows_set.php
     * @param int $id - lead id
     * @param array $rows - products data
     * @return array
     */
    public function set($id, $rows)
    {
        $fullResult = $this->client->call(
            'crm.lead.productrows.set',
            array(
                'id' => $id,
                'rows' => $rows
            )
        );
        return $fullResult;
    }
}
