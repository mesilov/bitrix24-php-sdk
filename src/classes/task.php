<?php
namespace Bitrix24\Task;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class TaskItem extends Bitrix24Entity
{
	/**
	 * get all methods and fields of B24 entity CTaskItem. Only for information!
	 * @return array
	 */
	public function getManifest()
	{
		$result = $this->client->call('task.item.getmanifest');
		return $result;
	}

	/**
	 * add new task
	 * @link http://dev.1c-bitrix.ru/rest_help/tasks/task/item/add.php
	 * @link http://dev.1c-bitrix.ru/rest_help/tasks/fields.php
	 * @param array $taskData
	 * @return array new task ID
	 * @throws Bitrix24Exception
	 */
	public function add($taskData)
	{
		$result = $this->client->call('task.item.add', array($taskData));
		return $result;
	}
}