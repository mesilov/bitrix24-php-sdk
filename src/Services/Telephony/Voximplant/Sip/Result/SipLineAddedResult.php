<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\ExternalCallFinishedItemResult;

class SipLineAddedResult extends AbstractResult
{
    public function getLine(): SipLineItemResult
    {
        return new SipLineItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}