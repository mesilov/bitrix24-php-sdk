<?php
namespace Bitrix24\Task;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class ElapsedItem
 * @package Bitrix24\Task
 */
class ElapsedItem extends Bitrix24Entity
{
	/**
	 * Return list of methods of the task.elapseditem.* type and their description.
	 * The returned value of this method is not intended for automatic processing because its format is subject to change without notice.
	 * This method may be useful as background information since it always contains updated information.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/elapseditem/getmanifest.php
	 * @return array
	 */
	public function getManifest()
	{
		$result = $this->client->call('task.elapseditem.getmanifest');
		return $result;
	}

	/**
	 * Returns a list of entries about elapsed time for a task.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/getlist.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $order array Array for result sorting. Sorting field may take the following values:
	 * 	ID – identifier of the entry about elapsed time;
	 * 	USER_ID – identifier of the user on whose behalf the entry about the elapsed time was made;
	 * 	MINUTES – elapsed time, minutes;
	 * 	SECONDS – elapsed time, seconds ;
	 * 	CREATED_DATE – entry creation date;
	 * 	DATE_START – start date;
	 * 	DATE_STOP – end date.
	 * 	Sorting direction can take the following values:
	 * 	asc – ascending;
	 * 	desc – descending;
	 * 	Optional. By default it is filtered by descending of the entry elapsed time identifier.
	 * @param $filter array Array of the time {"filtered_field": "filter value" [, ...]}. Filtered field can take the following values:
	 * 	ID – comment identifier;
	 * 	USER_ID – identifier of the user on whose behalf the entry about the elapsed time was made;
	 * 	CREATED_DATE – entry creation date.
	 * 	Filtration type may be indicated before the name of the field to be filtered:
	 * 	"!" – not equal;
	 * 	"<" – less;
	 * 	"<=" – less or equal;
	 * 	">" – more;
	 * 	">=" – more or equal.
	 * 	filter values - a single value or an array.
	 *	Optional. By default entries are not filtered.
	 * @return array
	 */
	public function getList($taskId, $order, $filter)
	{
		$result = $this->client->call('task.elapseditem.getlist',
			array(
				'TASKID' => $taskId,
				'ORDER' => $order,
				'FILTER' => $filter
			));
		return $result;
	}

	/**
	 * Returns an entry about elapsed time by its identifier.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/elapseditem/get.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $elapsedItemId integer Entry identifier. Required parameter.
	 * @return array
	 */
	public function get($taskId, $elapsedItemId)
	{
		$result = $this->client->call('task.checklistitem.get',
			array(
				'TASKID' => $taskId,
				'ITEMID' => $elapsedItemId
			));
		return $result;
	}

	/**
	 * Add time spent to the task. Return added record ID.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/elapseditem/add.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $fields array Array of time records and comments (SECONDS and COMMENT_TEXT). MINUTES may be used instead of SECONDS, but they may not be used at the same time.
	 * @return array
	 */
	public function add($taskId, $fields)
	{
		$result = $this->client->call('task.elapseditem.add', array($taskId, $fields));
		return $result;
	}

	/**
	 * 	Change parameters of the specified time spent record.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/elapseditem/update.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $elapsedItemId integer Entry identifier. Required parameter.
	 * @param $fields array Array of time records and comments (SECONDS and COMMENT_TEXT). MINUTES may be used instead of SECONDS, but they may not be used at the same time.
	 * @return array
	 */
	public function update($taskId, $elapsedItemId, $fields)
	{
		$result = $this->client->call('task.elapseditem.update', array($taskId, $elapsedItemId, array($fields)));
		return $result;
	}

	/**
	 * Delete time spent record.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/elapseditem/delete.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $elapsedItemId integer Time spent record ID.
	 * @return array
	 */
	public function delete($taskId, $elapsedItemId)
	{
		$result = $this->client->call('task.elapseditem.delete', array($taskId, $elapsedItemId));
		return $result;
	}

	/**
	 * Verify whether the action is allowed.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/elapseditem/isactionallowed.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $elapsedItemId integer Time spent record ID.
	 * @param $actionId integer Identifier of the action to be checked:
	 * 	Action ID:
	 * 	1 - ACTION_ELAPSED_TIME_ADD;
	 * 	2 - ACTION_ELAPSED_TIME_MODIFY;
	 * 	3 - ACTION_ELAPSED_TIME_REMOVE.
	 * Required parameter.
	 * @return array
	 */
	public function isActionAllowed($taskId, $elapsedItemId, $actionId)
	{
		$result = $this->client->call('task.elapseditem.isActionAllowed', array($taskId, $elapsedItemId, $actionId));
		return $result;
	}
}