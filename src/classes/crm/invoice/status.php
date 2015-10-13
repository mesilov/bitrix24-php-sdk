<?php
namespace Bitrix24\CRM\Invoice;
use Bitrix24\Bitrix24Entity;

class Status extends Bitrix24Entity
{
    /**
     * Get list of Invoice.Status items.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice_status/crm_invoice_status_list.php
     * @param array $order - order of items
     * @param array $filter - filter array
     * @param array $select - array of columns to select
	 * @param integer $start - entity number to start from (usually returned in 'next' field of previous 'crm.invoice.status.list' API call)
     * @return array
     */
    public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.invoice.status.list',
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
     * get by id
     * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_status_get.php
	 * @param integer $invoiceStatusId - invoice status identifier
     * @return array
     */
    public function get($invoiceStatusId)
    {
        $fullResult = $this->client->call(
            'crm.invoice.status.get',
            array('id' => $invoiceStatusId)
        );
        return $fullResult;
    }

}

