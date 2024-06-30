<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallInit;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnVoximplantCallInit extends AbstractEventRequest
{
    public const CODE = 'ONVOXIMPLANTCALLINIT';

    public function getPayload(): OnVoximplantCallInitEventPayload
    {
        return new OnVoximplantCallInitEventPayload($this->eventPayload['data']);
    }
}