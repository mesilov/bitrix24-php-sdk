<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Workflow\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class WorkflowInstanceStartResult extends AbstractResult
{
    public function getRunningWorkflowInstanceId(): string
    {
        return $this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}