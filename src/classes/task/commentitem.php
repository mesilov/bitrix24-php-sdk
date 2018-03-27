<?php
namespace Bitrix24\Task;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class CommentItem
 * @package Bitrix24\Task
 */
class CommentItem extends Bitrix24Entity
{
	/**
	 * Returns the list of methods of the type task.commentitem.* and their description.
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/commentitem/getmanifest.php
	 * @return array
	 */
	public function getManifest()
	{
		$result = $this->client->call('task.commentitem.getmanifest');
		return $result;
	}

	/**
	 * Returns the list of comments to a task.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/commentitem/getlist.php
	 * @param $taskId integer
	 * @param $order array
	 * @param $filter array
	 * @return array
	 */
	public function getList($taskId, $order, $filter)
	{
		$result = $this->client->call('task.commentitem.getlist', array($taskId, $order, $filter));
		return $result;
	}

	/**
	 * Returns comments to a task.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/commentitem/get.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $commentItemId integer Comment identifier. Required parameter.
	 * @return array
	 */
	public function get($taskId, $commentItemId)
	{
		$result = $this->client->call('task.commentitem.get',
			array(
				'TASKID' => $taskId,
				'ITEMID' => $commentItemId
			));
		return $result;
	}

	/**
	 * Creates a new comment to a task. Returns the identifier to the comment added.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/commentitem/add.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $fields array Data field array for a task (POST_MESSAGE). Required parameter.
	 * @return array
	 */
	public function add($taskId, $fields)
	{
		$result = $this->client->call('task.commentitem.add', 
			array(
				'TASKID' => $taskId,
				'arFields' => $fields
			));
		return $result;
	}

	/**
	 * Updates the comment data.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/commentitem/update.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $commentItemId integer Comment identifier. Required parameter.
	 * @param $fields array Data field array for a task (POST_MESSAGE). Required parameter.
	 * @return array
	 */
	public function update($taskId, $commentItemId, $fields)
	{
		$result = $this->client->call('task.commentitem.add', array($taskId, $commentItemId, array($fields)));
		return $result;
	}

	/**
	 * Delete a comment.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/commentitem/delete.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $commentItemId integer Comment identifier. Required parameter.
	 * @return array
	 */
	public function delete($taskId, $commentItemId)
	{
		$result = $this->client->call('task.commentitem.add', array($taskId, $commentItemId));
		return $result;
	}

	/**
	 * Checks if the action is permitted.
	 * @see http://www.bitrixsoft.com/rest_help/tasks/task/checklistitem/isactionallowed.php
	 * @param $taskId integer Task identifier. Required parameter.
	 * @param $commentItemId integer Comment identifier. Required parameter.
	 * @param $actionId integer Identifier of the action to be checked:
	 * 	  1 - ACTION_COMMENT_ADD;
	 *	  2 - ACTION_COMMENT_MODIFY;
	 *	  3 - ACTION_COMMENT_REMOVE.
	Required parameter.
	 * @return array
	 */
	public function isActionAllowed($taskId, $commentItemId, $actionId)
	{
		$result = $this->client->call('task.commentitem.isactionallowed', array($taskId, $commentItemId, $actionId));
		return $result;
	}
}
