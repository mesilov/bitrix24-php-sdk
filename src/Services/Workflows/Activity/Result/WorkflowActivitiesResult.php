<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Activity\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class WorkflowActivitiesResult extends AbstractResult
{
    /**
     * @throws BaseException
     */
    public function getActivities(): array
    {
        return $this->getCoreResponse()->getResponseData()->getResult();
    }
}