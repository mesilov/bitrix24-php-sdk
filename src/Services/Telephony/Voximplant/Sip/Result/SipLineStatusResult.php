<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\ExternalCallFinishedItemResult;

class SipLineStatusResult extends AbstractResult
{
    public function getStatus(): SipLineStatusItemResult
    {
        return new SipLineStatusItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}