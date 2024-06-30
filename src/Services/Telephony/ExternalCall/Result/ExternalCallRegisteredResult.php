<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallRegisteredResult extends AbstractResult
{
    public function getExternalCallRegistered(): ExternalCallRegisteredItemResult
    {
        return new ExternalCallRegisteredItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}