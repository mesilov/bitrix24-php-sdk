<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Event\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class EventSendResult extends AbstractResult
{
    public function isSuccess(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}