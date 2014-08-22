<?php
namespace Bitrix24\Departments;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Departments\Fields;
use Bitrix24\Presets\Main;

class Department extends Bitrix24Entity
{
	/**
	 * Get list of fields entity Department
	 * @link http://dev.1c-bitrix.ru/rest_help/departments/department_fields.php
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function fields()
	{
		$result = $this->client->call('department.fields');
		return $result['result'];
	}

	/**
	 * Get filtered list of departments
	 * @link http://dev.1c-bitrix.ru/rest_help/departments/department_get.php
	 * @param $sort
	 * @param $order
	 * @param $filter
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function get($sort, $order, $filter)
	{
		$filterCode = array_keys($filter);
		$filterCode = $filterCode[0];
		$filterValue = array_values($filter);
		$filterValue = $filterValue[0];
		$arFilter = array(Main::SORT => $sort, Main::ORDER => $order, $filterCode => $filterValue);
		$result = $this->client->call('department.get', $arFilter);
		return $result;
	}

	/**
	 * Create department. Works with user, who has rights for modify company structure
	 * @link http://dev.1c-bitrix.ru/rest_help/departments/department_add.php
	 * @param $name
	 * @param $sort
	 * @param $parent
	 * @param $head
	 * @throws Bitrix24Exception
	 * @return integer
	 */
	public function add($name, $sort, $parent, $head)
	{
		$result = $this->client->call('department.add', array(
			Fields::NAME 	=> $name,
			Fields::SORT 	=> $sort,
			Fields::PARENT 	=> $parent,
			Fields::HEAD	=> $head
		));
		return $result['result'];
	}

	/**
	 * Update department. Works with user, who has rights for modify company structure
	 * @link http://dev.1c-bitrix.ru/rest_help/departments/department_update.php
	 * @param $id - required
	 * @param $name - required
	 * @param $sort
	 * @param $parent
	 * @param $head
	 * @throws Bitrix24Exception
	 * @return boolean
	 */
	public function update($id, $name, $sort, $parent, $head)
	{
		$result = $this->client->call('department.update', array(
			Fields::ID 		=> $id,
			Fields::NAME 	=> $name,
			Fields::SORT 	=> $sort,
			Fields::PARENT 	=> $parent,
			Fields::HEAD	=> $head
		));
		return $result['result'];
	}

	/**
	 * Delete department. Works with user, who has rights for modify company structure
	 * @param $id integer
	 * @throws Bitrix24Exception
	 * @return boolean
	 */
	public function delete($id)
	{
		$result = $this->client->call('department.delete', array(Fields::ID => $id));
		return $result['result'];
	}
}
