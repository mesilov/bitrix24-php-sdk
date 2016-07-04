<?php
namespace Bitrix24\Task;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class Item
 * @package Bitrix24\Task
 */
class Item extends Bitrix24Entity
{
	/**
	 * get all methods and fields of B24 entity CTaskItem. Only for information!
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/getmanifest.php
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

	/**
	 * Return array of task data fields (TITLE, DESCRIPTION, etc.)
	 * @param $taskId
	 * @return array
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function getData($taskId)
	{
		$result = $this->client->call('task.item.getdata', array($taskId));
		return $result;
	}

	/**
	 * Update task data. The following fields may be updated. Business logic and permissions are taken into account when updating task data.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/update.php
	 * @param $taskId integer Task ID.
	 * @param $taskData array List of updated fields.
	 * @return array
	 *
	 */
	public function update($taskId, $taskData)
	{
		$result = $this->client->call('task.item.update', array($taskId, $taskData));
		return $result;
	}

	/**
	 * Delete task.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/delete.php
	 * @param $taskId integer Task ID.
	 * @return array
	 */
	public function delete($taskId)
	{
		$result = $this->client->call('task.item.delete', array($taskId));
		return $result;
	}

	/**
	 * Return task description.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/getdescription.php
	 * @param $taskId integer Task ID.
	 * @param $format integer 1 (Corresponds to the PHP constant CTaskItem::DESCR_FORMAT_RAW) �
	 * description will be returned in the format it is stored in the database (HTML or BB-code), will not be sanitized;
	 * 2 (Corresponds to the PHP constant CTaskItem::DESCR_FORMAT_HTML) � description will be returned in HTML, will first be sanitized (if included in task module settings);
	 * 3 (Corresponds to the PHP constant CTaskItem::DESCR_FORMAT_PLAIN_TEXT) � description will be returned as plain text (no HTML tags).
	 * @return array
	 */
	public function getDescription($taskId, $format)
	{
		$result = $this->client->call('task.item.getdescription', $taskId, $format);
		return $result;
	}

	/**
	 * Return array of links to files attached to the task.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/getfiles.php
	 * @param $taskId integer Task ID.
	 * @return array
	 */
	public function getFiles($taskId)
	{
		$result = $this->client->call('task.item.getfiles', array($taskId));
		return $result;
	}

	/**
	 * Return array with parent task IDs
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/getdependson.php
	 * @param $taskId integer Task ID.
	 * @return array
	 */
	public function getDependSon($taskId)
	{
		$result = $this->client->call('task.item.getdependson', array($taskId));
		return $result;
	}

	/**
	 * Return array of allowed task actions IDs (see PHP class constants CTaskItem).
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/getallowedactions.php
	 * @param $taskId integer Task ID.
	 * @return array
	 */
	public function getAllowedActions($taskId)
	{
		$result = $this->client->call('task.item.getallowedactions', array($taskId));
		return $result;
	}

	/**
	 * Return an array whose keys are acton names (the names correspond to PHP class constants CTaskItem) and values show whether the action is allowed (true) or not allowed (false).
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/getallowedtaskactionsasstrings.php
	 * @param $taskId integer Task ID.
	 * @return array
	 */
	public function getAllowedTaskActionsAsStrings($taskId)
	{
		$result = $this->client->call('task.item.getallowedtaskactionsasstrings', array($taskId));
		return $result;
	}

	/**
	 * Return true if action is allowed, else returns false.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/isactionallowed.php
	 * @param $taskId integer Task ID.
	 * @param $actionId integer Validated action ID (see CTaskItem::ACTION_* constants of PHP class CTaskItem).
	 * @return array
	 */
	public function isActionAllowed($taskId, $actionId)
	{
		$result = $this->client->call('task.item.isactionallowed', array($taskId), array($actionId));
		return $result;
	}

	/**
	 * Delegate task to a user.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/delegate.php
	 * @param $taskId integer Task ID
	 * @param $userId integer New responsible person ID
	 * @return array
	 */
	public function delegate($taskId, $userId)
	{
		$result = $this->client->call('task.item.delegate', array($taskId), array($userId));
		return $result;
	}

	/**
	 * Change task status to In Progress
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/startexecution.php
	 * @param $taskId integer Task ID
	 * @return array
	 */
	public function startExecution($taskId)
	{
		$result = $this->client->call('task.item.startexecution', array($taskId));
		return $result;
	}

	/**
	 * Change task status to Deferred
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/defer.php
	 * @param $taskId integer Task ID
	 * @return array
	 */
	public function defer($taskId)
	{
		$result = $this->client->call('task.item.defer', array($taskId));
		return $result;
	}

	/**
	 * Change status to Completed or Supposedly completed (requires creator's attention).
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/complete.php
	 * @param $taskId integer Task ID
	 * @return array
	 */
	public function complete($taskId)
	{
		$result = $this->client->call('task.item.complete', array($taskId));
		return $result;
	}

	/**
	 * Change status to Pending.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/renew.php
	 * @param $taskId integer Task ID
	 * @return array
	 */
	public function renew($taskId)
	{
		$result = $this->client->call('task.item.renew', array($taskId));
		return $result;
	}

	/**
	 * Change status of task waiting for confirmation to Completed.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/approve.php
	 * @param $taskId integer Task ID
	 * @return array
	 */
	public function approve($taskId)
	{
		$result = $this->client->call('task.item.approve', array($taskId));
		return $result;
	}

	/**
	 * Change status of task waiting for confirmation to Pending.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/item/disapprove.php
	 * @param $taskId integer Task ID
	 * @return array
	 */
	public function disapprove($taskId)
	{
		$result = $this->client->call('task.item.disapprove', array($taskId));
		return $result;
	}
}