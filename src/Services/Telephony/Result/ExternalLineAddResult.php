<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalLineAddResult extends AbstractResult
{
    /**
     * @return bool
     * @throws BaseException
     */
    public function isSuccess(): bool
    {
        return (bool)$this->getCoreResponse()->getResponseData()->getResult()->getResultData();
    }

}