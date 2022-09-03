<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class EventHandlerUnbindResult extends AbstractResult
{
    /**
     * @return int
     * @throws BaseException
     */
    public function getUnbindedHandlersCount(): int
    {
        return (int)$this->getCoreResponse()->getResponseData()->getResult()['count'];
    }
}