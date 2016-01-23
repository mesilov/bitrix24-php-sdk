<?php

namespace Bitrix24\Task;

use Bitrix24\Bitrix24Entity;

/**
 * Class Planner.
 */
class planner extends Bitrix24Entity
{
    /**
     * Return an array with IDs of tasks planned for the day.
     *
     * @return array
     */
    public function getList()
    {
        $fullResult = $this->client->call('task.planner.getlist');

        return $fullResult;
    }
}
