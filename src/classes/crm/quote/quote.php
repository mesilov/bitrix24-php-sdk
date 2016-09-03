<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;

class Quote extends Bitrix24Entity 
{
    /**
     * Get list of quote items.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/quote/crm_quote_list.php
     * @param array $order - order of task items
     * @param array $filter - filter array
     * @param array $select - array of collumns to select
     * @param integer $start - entity number to start from (usually returned in 'next' field of previous 'crm.quote.list' API call)
     * @return array
     */
    public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.quote.list',
            array(
                'order' => $order,
                'filter'=> $filter,
                'select'=> $select,
		'start'	=> $start
            )
        );
        return $fullResult;
    }

    /**
     * get quote by id
     * @var $quoteId integer quote identifier
     * @link http://dev.1c-bitrix.ru/rest_help/crm/quote/crm_quote_get.php
     * @return array
     */
    public function get($quoteId)
    {
        $fullResult = $this->client->call(
            'crm.quote.get',
            array('id' => $quoteId)
        );
        return $fullResult;
    }

    /**
     * delete quote by id
     * @var $quoteId integer quote identifier
     * @link http://dev.1c-bitrix.ru/rest_help/crm/quote/crm_quote_delete.php
     * @return array
     */
    public function delete($quoteId)
    {
        $fullResult = $this->client->call(
            'crm.quote.delete',
            array('id' => $quoteId)
        );
        return $fullResult;
    }

    /**
     * Add a new quote to CRM
     * @param array $fields array of fields
     * @link http://dev.1c-bitrix.ru/rest_help/crm/quote/crm_quote_add.php
     * @return array
     */
    public function add($fields = array())
    {
        $fullResult = $this->client->call(
            'crm.quote.add',
            array('fields' => $fields)
        );
        return $fullResult;
    }

    /**
     * update quote by id
     * @var $quoteId integer quote identifier
     * @var $quoteFields array quote fields to update
     * @link http://dev.1c-bitrix.ru/rest_help/crm/quote/crm_quote_update.php
     * @return array
     */
    public function update($quoteId, $quoteFields)
    {
        $fullResult = $this->client->call(
            'crm.quote.update',
            array(
                'id' => $quoteId,
                'fields' => $quoteFields
            )
        );
        return $fullResult;
    }

    /**
     * get list of quote fields with description
     * @link http://dev.1c-bitrix.ru/rest_help/crm/quote/crm_quote_fields.php
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.quote.fields'
        );
        return $fullResult;
    }
}
