<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Userfield\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class UserfieldTypesResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\CRM\Userfield\Result\UserfieldTypeItemResult[]
     * @throws BaseException
     */
    public function getTypes(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $item) {
            $res[] = new UserfieldTypeItemResult($item);
        }

        return $res;
    }
}