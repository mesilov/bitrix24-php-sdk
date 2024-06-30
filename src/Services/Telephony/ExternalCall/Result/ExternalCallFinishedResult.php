<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallFinishedResult extends AbstractResult
{
    public function getExternalCallFinished(): ExternalCallFinishedItemResult
    {
        return new ExternalCallFinishedItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}