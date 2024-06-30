<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Task\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class WorkflowTaskCompleteResult extends AbstractResult
{
    public function isSuccess(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}