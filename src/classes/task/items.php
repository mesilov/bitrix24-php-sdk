<?php

namespace Bitrix24\Task;

use Bitrix24\Bitrix24Entity;

/**
 * Class Items.
 */
class items extends Bitrix24Entity
{
    /**
     * Get list of Task items. If array $NAV_PARAMS set to NULL method will return all tasks from filter
     * without 50 task per page limit.
     *
     * @link http://www.bitrixsoft.com/rest_help/tasks/task/items/getlist.php
     *
     * @param array $ORDER      - order of task items
     * @param array $FILTER     - filter array
     * @param array $TASKDATA   - array of collumns to select
     * @param array $NAV_PARAMS Page-by-page navigation. The following options are available: nPageSize - Number of elements on a page, iNumPage - Page number.
     *
     * @return array
     */
    public function getList($ORDER = [], $FILTER = [], $TASKDATA = [], $NAV_PARAMS = [])
    {
        $fullResult = $this->client->call(
            'task.items.getlist',
            [
                'ORDER'       => $ORDER,
                'FILTER'      => $FILTER,
                'TASKDATA'    => $TASKDATA,
                ['NAV_PARAMS' => $NAV_PARAMS],
            ]
        );

        return $fullResult;
    }
}
