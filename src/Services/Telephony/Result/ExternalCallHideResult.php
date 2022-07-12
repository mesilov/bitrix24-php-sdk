<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallHideResult extends AbstractResult
{
    /**
     * @return bool
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getExternalHideCalls(): bool
    {
        return (bool)$this->getCoreResponse()->getResponseData()->getResult()->getResultData();
    }
}