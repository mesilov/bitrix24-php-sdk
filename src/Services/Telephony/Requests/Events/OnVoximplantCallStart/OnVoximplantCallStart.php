<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallStart;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;
use Bitrix24\SDK\Services\Telephony\Requests\Events\Auth;

/**
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallstart.php
 */
class OnVoximplantCallStart extends AbstractEventRequest
{
    /**
     * @return \Bitrix24\SDK\Services\Telephony\Requests\Events\Auth
     */
    public function getAuth(): Auth
    {
        return new Auth($this->eventPayload['auth']);
    }
    /**
     * @return \Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallStart\CallData
     */
    public function getCallData(): CallData
    {
        return new CallData($this->eventPayload['data']);
    }
}