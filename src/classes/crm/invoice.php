<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;

class Invoice extends Bitrix24Entity
{
    /**
     * Get list of lead items.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_list.php
     * @param array $order - order of task items
     * @param array $filter - filter array
     * @param array $select - array of collumns to select
     * @return array
     */
    public function getList($order = array(), $filter = array(), $select = array())
    {
        $fullResult = $this->client->call(
            'crm.invoice.list',
            array(
                'order' => $order,
                'filter'=> $filter,
                'select'=> $select,
            )
        );
        return $fullResult;
    }

    /**
     * get invoice by id
     * @var $invoiceId integer invoice identifier
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_get.php
     * @return array
     */
    public function get($invoiceId)
    {
        $fullResult = $this->client->call(
            'crm.invoice.get',
            array('id' => $invoiceId)
        );
        return $fullResult;
    }

    /**
     * delete invoice by id
     * @var $invoiceId integer invoice identifier
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_delete.php
     * @return array
     */
    public function delete($invoiceId)
    {
        $fullResult = $this->client->call(
            'crm.invoice.delete',
            array('id' => $invoiceId)
        );
        return $fullResult;
    }

    /**
     * Add a new invoice to CRM
     * @param array $fields array of fields
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_add.php
     * @return array
     */
    public function add($fields = array())
    {
        $fullResult = $this->client->call(
            'crm.invoice.add',
            array('fields' => $fields)
        );
        return $fullResult;
    }

    /**
     * get list of invoice fields with description
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_fields.php
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