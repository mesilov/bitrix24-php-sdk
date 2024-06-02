<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class SearchCrmEntitiesResult extends AbstractResult
{
    /**
     * @return SearchCrmEntitiesItemResult[]
     * @throws BaseException
     */
    public function getCrmEntities(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new SearchCrmEntitiesItemResult($item);
        }
        return $res;
    }
}