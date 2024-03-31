<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Workflow\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Core\Result\AbstractResult;

class WorkflowInstancesResult extends AbstractResult
{
    /**
     * @return WorkflowInstanceItemResult[]
     * @throws BaseException
     */
    public function getInstances(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new WorkflowInstanceItemResult($item);
        }

        return $res;
    }
}