<?php

namespace Bitrix24\CRM;

use Bitrix24\Bitrix24Entity;

class invoice extends Bitrix24Entity
{
    /**
     * @var string STATUS_DRAFT pre-defined invoice status "draft"
     */
    const STATUS_DRAFT = 'N';
    /**
     * @var string STATUS_PAID pre-defined invoice status "paid"
     */
    const STATUS_PAID = 'P';
    /**
     * @var string STATUS_REJECTED pre-defined invoice status "rejected"
     */
    const STATUS_REJECTED = 'D';

    /**
     * Get list of lead items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_list.php
     *
     * @param array $order  - order of task items
     * @param array $filter - filter array
     * @param array $select - array of collumns to select
     * @param int   $start  - entity number to start from (usually returned in 'next' field of previous 'crm.invoice.list' API call)
     *
     * @return array
     */
    public function getList($order = [], $filter = [], $select = [], $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.invoice.list',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
        'start'          => $start,
            ]
        );

        return $fullResult;
    }

    /**
     * get invoice by id.
     *
     * @var integer invoice identifier
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_get.php
     *
     * @return array
     */
    public function get($invoiceId)
    {
        $fullResult = $this->client->call(
            'crm.invoice.get',
            ['id' => $invoiceId]
        );

        return $fullResult;
    }

    /**
     * delete invoice by id.
     *
     * @var integer invoice identifier
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_delete.php
     *
     * @return array
     */
    public function delete($invoiceId)
    {
        $fullResult = $this->client->call(
            'crm.invoice.delete',
            ['id' => $invoiceId]
        );

        return $fullResult;
    }

    /**
     * Add a new invoice to CRM.
     *
     * @param array $fields array of fields
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_add.php
     *
     * @return array
     */
    public function add($fields = [])
    {
        $fullResult = $this->client->call(
            'crm.invoice.add',
            ['fields' => $fields]
        );

        return $fullResult;
    }

    /**
     * update invoice by id.
     *
     * @var integer        invoice identifier
     * @var $invoiceFields array invoice fields to update
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_update.php
     *
     * @return array
     */
    public function update($invoiceId, $invoiceFields)
    {
        $fullResult = $this->client->call(
            'crm.invoice.update',
            [
                'id'     => $invoiceId,
                'fields' => $invoiceFields,
            ]
        );

        return $fullResult;
    }

    /**
     * get list of invoice fields with description.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_fields.php
     *
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.invoice.fields'
        );

        return $fullResult;
    }
}
