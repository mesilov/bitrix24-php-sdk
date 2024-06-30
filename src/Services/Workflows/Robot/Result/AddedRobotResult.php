<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Robot\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class AddedRobotResult extends AbstractResult
{
    public function isSuccess(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}