<?php
namespace Bitrix24\Task;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class ChecklistItem
 * @package Bitrix24\Task
 */
class ChecklistItem extends Bitrix24Entity
{
	/**
	 * Returns a list of methods of the type task.checklistitem.* and their description.
	 * The returned value of this method is not intended for automatic processing because its format is subject to change without notice.
	 * This method may be useful as background information since it always contains updated information.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/getmanifest.php
	 * @return array
	 */
	public function getManifest()
	{
		$result = $this->client->call('task.checklistitem.getmanifest');
		return $result;
	}

	/**
	 * Returns the list of check list elements in a task.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/getlist.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $order array Array for result sorting. The sorting field can take the following values:
	 * 	ID – check list element identifier;
	 * 	CREATED_BY – identifier of the user who has created the element;
	 * 	TOGGLED_BY – identifier of the user who has modified the check list element status;
	 * 	TOGGLED_DATE – the time when the check list element status was changed;
	 * 	TITLE – check list element header;
	 * 	SORT_INDEX – element sorting index;
	 * 	IS_COMPLETE – the element is marked as completed;
	 * 	The sorting direction can take the following values:
	 * 	asc – ascending;
	 * 	desc – descending;
	 * 	Optional. By default it is filtered by descending identifier of a check list element.
	 * @return array
	 */
	public function getList($taskId, $order)
	{
		$result = $this->client->call('task.checklistitem.getlist',
			array(
				'TASKID' => $taskId,
				'ORDER' => $order
			));
		return $result;
	}

	/**
	 * Returns a check list element by its identifier.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/get.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $checklistItemId integer Element identifier. Required parameter.
	 * @return array
	 */
	public function get($taskId, $checklistItemId)
	{
		$result = $this->client->call('task.checklistitem.get',
			array(
				'TASKID' => $taskId,
				'ITEMID' => $checklistItemId
			));
		return $result;
	}

	/**
	 * Adds a new check list element to a task. Returns the identifier of the added element.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/add.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $fields array Array of fields of a check list element (TITLE, SORT_INDEX, IS_COMPLETE). Required parameter.
	 * @return array
	 */
	public function add($taskId, $fields)
	{
		$result = $this->client->call('task.checklistitem.add', array($taskId, $fields));
		return $result;
	}

	/**
	 * Updates data of a check list element.
	 * Before updating data, it is advisable to make sure the action is permitted (task.checklistitem.isactionallowed).
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/update.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $checklistItemId integer Check list element identifier. Required parameter.
	 * @param $fields array Array of fields of a check list elements (TITLE, SORT_INDEX, IS_COMPLETE). Required parameter.
	 * @return array
	 */
	public function update($taskId, $checklistItemId, $fields)
	{
		$result = $this->client->call('task.checklistitem.update', array($taskId, $checklistItemId, array($fields)));
		return $result;
	}

	/**
	 * Deletes check list element.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/complete.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $checklistItemId integer Check list element identifier. Required parameter.
	 * @return array
	 */
	public function delete($taskId, $checklistItemId)
	{
		$result = $this->client->call('task.checklistitem.delete', array($taskId, $checklistItemId));
		return $result;
	}

	/**
	 * Marks a check list element as completed.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/complete.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $checklistItemId integer Check list element identifier. Required parameter.
	 * @return array
	 */
	public function complete($taskId, $checklistItemId)
	{
		$result = $this->client->call('task.checklistitem.complete', array($taskId, $checklistItemId));
		return $result;
	}

	/**
	 * Marks a check list element as active again.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/renew.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $checklistItemId integer Check list element identifier. Required parameter.
	 * @return array
	 */
	public function renew($taskId, $checklistItemId)
	{
		$result = $this->client->call('task.checklistitem.renew', array($taskId, $checklistItemId));
		return $result;
	}

	/**
	 * Moves a check list element and places it in the list after the indicated one.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/moveafteritem.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $checklistItemId integer Check list element identifier. Required parameter.
	 * @param $checklistAfterItemId integer Check list element identifier, after which the given element will be placed. Required parameter.
	 * @return array
	 */
	public function moveAfterItem($taskId, $checklistItemId, $checklistAfterItemId)
	{
		$result = $this->client->call('task.checklistitem.moveafteritem', array($taskId, $checklistItemId, $checklistAfterItemId));
		return $result;
	}

	/**
	 * Checks whether the action is permitted.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/isactionallowed.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $checklistItemId integer Comment identifier. Required parameter.
	 * @param $actionId integer Identifier of the action to be checked:
	 * 1 - ACTION_ADD;
	 * 2 - ACTION_MODIFY;
	 * 3 - ACTION_REMOVE;
	 * 4 - ACTION_TOGGLE.
	 * Required parameter.
	 * @return array
	 */
	public function isActionAllowed($taskId, $checklistItemId, $actionId)
	{
		$result = $this->client->call('task.checklistitem.isactionallowed', array($taskId, $checklistItemId, $actionId));
		return $result;
	}
}
