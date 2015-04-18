<?php
namespace Bitrix24\CRM\Deal;
use Bitrix24\Bitrix24Entity;

class Deal extends Bitrix24Entity
{
	/**
	 * Add a new deal to CRM
	 * @param array $fields array of fields
	 * @param array $fields array of params
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_add.php
	 * @return array
	 */
	public function add($fields = array(), $params = array())
	{
		$fullResult = $this->client->call(
			'crm.deal.add',
			array('fields' => $fields)
		);
		return $fullResult;
	}

	/**
	 * delete deal by id
	 * @var $dealId integer deal identifier
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_delete.php
	 * @return array
	 */
	public function delete($dealId)
	{
		$fullResult = $this->client->call(
			'crm.deal.delete',
			array('id' => $dealId)
		);
		return $fullResult;
	}

	/**
	 * get list of deal fields with description
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_fields.php
	 * @return array
	 */
	public function fields()
	{
		$fullResult = $this->client->call(
			'crm.invoice.fields'
		);
		return $fullResult;
	}

	/**
	 * get deal by id
	 * @var $dealId integer deal identifier
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_get.php
	 * @return array
	 */
	public function get($dealId)
	{
		$fullResult = $this->client->call(
			'crm.deal.get',
			array('id' => $dealId)
		);
		return $fullResult;
	}

	/**
	 * Get list of deal items.
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_list.php
	 * @param array $order - order of deal items
	 * @param array $filter - filter array
	 * @param array $select - array of collumns to select
	 * @return array
	 */
	public function getList($order = array(), $filter = array(), $select = array())
	{
		$fullResult = $this->client->call(
			'crm.deal.list',
			array(
				'order' => $order,
				'filter'=> $filter,
				'select'=> $select,
			)
		);
		return $fullResult;
	}

	/**
	 * update deal by id
	 * @var $dealId integer deal identifier
	 * @var $dealFields array deal fields to update
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_update.php
	 * @return array
	 */
	public function update($dealId, $dealFields)
	{
		$fullResult = $this->client->call(
			'crm.deal.update',
			array(
				'id' => $dealId,
				'fields' => $dealFields
			)
		);
		return $fullResult;
	}


}