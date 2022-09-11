<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Placement\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class PlacementLocationCodesResult extends AbstractResult
{
    /**
     * @return array
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getLocationCodes(): array
    {
        return $this->getCoreResponse()->getResponseData()->getResult();
    }
}