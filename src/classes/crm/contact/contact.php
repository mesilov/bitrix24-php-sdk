<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class Contact extends Bitrix24Entity
{
	/**
	 * Get list of lead items.
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_list.php
	 * @param array $order - order of task items
	 * @param array $filter - filter array
	 * @param array $select - array of collumns to select
	 * @param integer $start - entity number to start from (usually returned in 'next' field of previous 'crm.contact.list' API call)
	 * @return array
	 * @throws Bitrix24Exception
	 *
	 */
	public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
	{
		$fullResult = $this->client->call(
			'crm.contact.list',
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
	 * Add a new contact to CRM
	 * @param array $fields array of fields
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_add.php
	 * @return array
	 * @throws Bitrix24Exception
	 *
	 */
	public function add($fields = array())
	{
		$fullResult = $this->client->call(
			'crm.contact.add',
			array('fields' => $fields)
		);
		return $fullResult;
	}

	/**
	 * Get contact by identifier
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_get.php
	 * @param integer $bitrix24UserId contact identifier
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function get($bitrix24UserId)
	{
		$fullResult = $this->client->call(
			'crm.contact.get',
			array('id' => $bitrix24UserId)
		);
		return $fullResult;
	}

	/**
	 * get list of contact fields with description
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_fields.php
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function fields()
	{
		$fullResult = $this->client->call(
			'crm.contact.fields'
		);
		return $fullResult;
	}
}
