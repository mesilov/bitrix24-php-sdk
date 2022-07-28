<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

/**
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallstart.php
 */
class OnVoximplantCallStart extends AbstractEventRequest
{
    /**
     * @return string Call identifier.
     */
    public function getCallId(): string
    {
        return $this->eventPayload['CALL_ID'];
    }

    /**
     * @return int Identifier of the user who responded the call.
     */
    public function getUserId(): int
    {
        return (int)$this->eventPayload['USER_ID'];
    }
}