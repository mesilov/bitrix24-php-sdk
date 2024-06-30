<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Robot\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class WorkflowRobotsResult extends AbstractResult
{
    /**
     * @throws BaseException
     */
    public function getRobots(): array
    {
        return $this->getCoreResponse()->getResponseData()->getResult();
    }
}