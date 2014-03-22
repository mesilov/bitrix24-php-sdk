<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;

class Lead extends Bitrix24Entity
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
			'crm.lead.list',
			array(
				'order' => $order,
				'filter'=> $filter,
				'select'=> $select,
			)
		);
		return $fullResult;
	}

	/**
	 * Add a new lead to CRM
	 * @param array $fields array of fields
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_add.php
	 * @return array
	 */
	public function add($fields = array())
	{
		$fullResult = $this->client->call(
			'crm.lead.add',
			array('fields' => $fields)
		);
		return $fullResult;
	}

	/**
	 * get list of lead fields with description
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_fields.php
	 * @return array
	 */
	public function fields()
	{
		$fullResult = $this->client->call(
			'crm.lead.fields'
		);
		return $fullResult;
	}
}