<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class EventListResult extends AbstractResult
{
    /**
     * @return array
     * @throws BaseException
     */
    public function getEvents(): array
    {
        return $this->getCoreResponse()->getResponseData()->getResult();
    }
}