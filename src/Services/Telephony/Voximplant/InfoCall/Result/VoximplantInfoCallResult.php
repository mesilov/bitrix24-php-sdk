<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\InfoCall\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class VoximplantInfoCallResult extends AbstractResult
{
    public function getCallResult(): VoximplantInfoCallItemResult
    {
        return new VoximplantInfoCallItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}