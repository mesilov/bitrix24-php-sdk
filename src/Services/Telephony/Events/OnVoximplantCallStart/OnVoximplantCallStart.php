<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallStart;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnVoximplantCallStart extends AbstractEventRequest
{
    public const CODE = 'ONVOXIMPLANTCALLSTART';

    public function getPayload(): OnVoximplantCallStartEventPayload
    {
        return new OnVoximplantCallStartEventPayload($this->eventPayload['data']);
    }
}