<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallRegisterResult extends AbstractResult
{
    /**
     * @return ExternalCallRegisterItemResult[]
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */

    public function getExternalCallRegister(): array
    {
       $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $item) {
            $res[] = new ExternalCallRegisterItemResult($item);
        }

        return $res;
    }
}