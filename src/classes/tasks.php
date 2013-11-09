<?php
namespace Bitrix24\Task;
use Bitrix24\Bitrix24Entity;


class TaskItems extends Bitrix24Entity
{
	/**
	 * Get list of Task items. If array $NAV_PARAMS not set method will return all tasks from filter
	 * without 50 task per page limit
	 * @link http://dev.1c-bitrix.ru/rest_help/tasks/task/items/getlist.php
	 * @param array $ORDER - order of task items
	 * @param array $FILTER - filter array
	 * @param array $TASKDATA - array of collumns to select
	 * @param array | null $NAV_PARAMS
	 * @return array
	 */
	public function getList($ORDER = array(), $FILTER = array(), $TASKDATA = array(), $NAV_PARAMS)
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
		if(!array_key_exists('nPageSize',$NAV_PARAMS) && (!array_key_exists('iNumPage', $NAV_PARAMS)))
		{
			if(self::ITEMS_PER_PAGE_LIMIT <= $fullResult['total'])
			{
				$totalPages = intval(ceil($fullResult['total']/self::ITEMS_PER_PAGE_LIMIT));
				$fullResult["next"] = $fullResult['total'];
				for($pageNumber = 2; $pageNumber <= $totalPages; $pageNumber++)
				{
					$nextResult = $this->client->call(
						'task.items.getlist',
						array(
							'ORDER' => $ORDER,
							'FILTER'=> $FILTER,
							'TASKDATA'=> $TASKDATA,
							array('NAV_PARAMS'=> array('nPageSize'=>50,'iNumPage'=>$pageNumber))
						)
					);
					$fullResult['result'] = array_merge($fullResult['result'], $nextResult['result']);
				}
			}
		}
		return $fullResult;
	}
}