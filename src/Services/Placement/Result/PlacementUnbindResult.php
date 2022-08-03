<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Placement\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class PlacementUnbindResult extends AbstractResult
{
    /**
     * @return int
     * @throws BaseException
     */
    public function getDeletedPlacementHandlersCount(): int
    {
        return (int)$this->getCoreResponse()->getResponseData()->getResult()['count'];
    }
}