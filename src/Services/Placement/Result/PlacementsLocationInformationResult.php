<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Placement\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class PlacementsLocationInformationResult extends AbstractResult
{
    /**
     * @return PlacementLocationItemResult[]
     * @throws BaseException
     */
    public function getPlacementsLocationInformation(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new PlacementLocationItemResult($item);
        }

        return $res;
    }
}