<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Placement\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class UserFieldTypesResult extends AbstractResult
{
    /**
     * @return UserFieldTypeItemResult[]
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getUserFieldTypes(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new UserFieldTypeItemResult($item);
        }

        return $res;
    }
}