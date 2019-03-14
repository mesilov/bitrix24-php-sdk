<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class Company
 * @package Bitrix24\CRM
 */
class Company extends Bitrix24Entity
{
	/**
	 * Get list of company items.
	 * @link http://www.bitrixsoft.com/rest_help/crm/company/crm_company_list.php
	 * @param array $order - order of task items
	 * @param array $filter - filter array
	 * @param array $select - array of collumns to select
	 * @param integer $start - entity number to start from (usually returned in 'next' field of previous 'crm.company.list' API call)
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
	{
		$fullResult = $this->client->call(
			'crm.company.list',
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
	 * Add a new company to CRM
	 * @param array $fields array of fields
	 * @link http://www.bitrixsoft.com/rest_help/crm/company/crm_company_add.php
	 * @return array
	 * @throws Bitrix24Exception
	 *
	 */
	public function add($fields = array())
	{
		$fullResult = $this->client->call(
			'crm.company.add',
			array('fields' => $fields)
		);
		return $fullResult;
	}

	/**
	 * Updates the specified (existing) company.
	 * @param array $bitrix24CompanyId integer
	 * @param array $fields array of fields
	 * @link http://www.bitrixsoft.com/rest_help/crm/company/crm_company_add.php
	 * @return array
	 * @throws Bitrix24Exception
	 *
	 */
	public function update($bitrix24CompanyId, $fields = array())
	{
		$fullResult = $this->client->call(
			'crm.company.update',
			array(
                            'id' => $bitrix24CompanyId,
                            'fields' => $fields,
                        )
		);
		return $fullResult;
	}

	/**
	 * Returns a company associated with the specified company ID.
	 * @link http://www.bitrixsoft.com/rest_help/crm/company/crm_company_get.php
	 * @param integer $bitrix24CompanyId company identifier
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function get($bitrix24CompanyId)
	{
		$fullResult = $this->client->call(
			'crm.company.get',
			array('id' => $bitrix24CompanyId)
		);
		return $fullResult;
	}

	/**
	 * Deletes the specified company and all the associated objects.
	 * @link http://www.bitrixsoft.com/rest_help/crm/company/crm_company_delete.php
	 * @param integer $bitrix24CompanyId company identifier
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function delete($bitrix24CompanyId)
	{
		$fullResult = $this->client->call(
			'crm.company.delete',
			array('id' => $bitrix24CompanyId)
		);
		return $fullResult;
	}

	/**
	 * Returns the description of the fields available to company.
	 * @link http://www.bitrixsoft.com/rest_help/crm/company/crm_company_fields.php
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function fields()
	{
		$fullResult = $this->client->call(
			'crm.company.fields'
		);
		return $fullResult;
	}
}
