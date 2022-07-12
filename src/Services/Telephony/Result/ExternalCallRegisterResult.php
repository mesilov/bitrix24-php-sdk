<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallRegisterResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallRegisterItemResult
     * @throws BaseException
     */
    public function getExternalCallRegister(): ExternalCallRegisterItemResult
    {
        return new ExternalCallRegisterItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }

}