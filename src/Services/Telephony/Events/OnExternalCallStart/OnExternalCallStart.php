<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnExternalCallStart;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnExternalCallStart extends AbstractEventRequest
{
    public const CODE = 'ONEXTERNALCALLSTART';

    public function getPayload(): OnExternalCallStartEventPayload
    {
        return new OnExternalCallStartEventPayload($this->eventPayload['data']);
    }
}