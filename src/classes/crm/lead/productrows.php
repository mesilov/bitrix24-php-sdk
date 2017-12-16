<?php
namespace Bitrix24\CRM\Lead;
use Bitrix24\Bitrix24Entity;

/**
 * Class ProductRows
 *
 * @link https://dev.1c-bitrix.ru/rest_help/crm/leads/index.php
 * @package Bitrix24\CRM\Lead
 */
class ProductRows extends Bitrix24Entity
{
    /**
     * Get product rows of lead by ID.

     * @link https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_productrows_get.php
     *
     * @param integer $id - lead ID.
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     */
    public function get($id)
    {
        $fullResult = $this->client->call(
            'crm.lead.productrows.get',
            array('id' => $id)
        );
        return $fullResult;
    }

    /**
     * Set product rows to lead by ID.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/komm_quote/crm_quote_productrows_set.php
     *
     * @param integer $id - lead ID
     * @param array $rows - array of products.
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalRenamedException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     */
    public function set($id, $rows = array())
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