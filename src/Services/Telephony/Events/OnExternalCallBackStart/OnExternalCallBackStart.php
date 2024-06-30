<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnExternalCallBackStart;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnExternalCallBackStart extends AbstractEventRequest
{
    public const CODE = 'ONEXTERNALCALLBACKSTART';

    public function getPayload(): OnExternalCallBackStartEventPayload
    {
        return new OnExternalCallBackStartEventPayload($this->eventPayload['data']);
    }
}