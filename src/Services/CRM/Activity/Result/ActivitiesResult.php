<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ActivitiesResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\CRM\Activity\Result\ActivityItemResult[]
     * @throws BaseException
     */
    public function getActivities(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new ActivityItemResult($item);
        }

        return $res;
    }
}