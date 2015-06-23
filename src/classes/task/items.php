<?php
namespace Bitrix24\Task;
use Bitrix24\Bitrix24Entity;

/**
 * Class Items
 * @package Bitrix24\Task
 */
class Items extends Bitrix24Entity
{
	/**
	 * Get list of Task items. If array $NAV_PARAMS set to NULL method will return all tasks from filter
	 * without 50 task per page limit
	 * @link http://www.bitrixsoft.com/rest_help/tasks/task/items/getlist.php
	 * @param array $ORDER - order of task items
	 * @param array $FILTER - filter array
	 * @param array $TASKDATA - array of collumns to select
	 * @param array $NAV_PARAMS Page-by-page navigation. The following options are available: nPageSize - Number of elements on a page, iNumPage - Page number.
	 * @return array
	 */
	public function getList($ORDER = array(), $FILTER = array(), $TASKDATA = array(), $NAV_PARAMS = array())
	{
		$fullResult = $this->client->call(
			'task.items.getlist',
			array(
				'ORDER' => $ORDER,
				'FILTER'=> $FILTER,
				'TASKDATA'=> $TASKDATA,
				array('NAV_PARAMS'=> $NAV_PARAMS)
			)
		);
		return $fullResult;
	}
}