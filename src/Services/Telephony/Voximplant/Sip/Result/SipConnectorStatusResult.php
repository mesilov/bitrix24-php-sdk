<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class SipConnectorStatusResult extends AbstractResult
{
    public function getStatus(): SipConnectorStatusItemResult
    {
        return new SipConnectorStatusItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}