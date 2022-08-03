<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class EventHandlersResult extends AbstractResult
{
    /**
     * @return EventHandlerItemResult[]
     * @throws BaseException
     */
    public function getEventHandlers(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $event) {
            $res[] = new EventHandlerItemResult($event);
        }

        return $res;
    }
}