<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallInit;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Requests\Events\Auth;
use Bitrix24\SDK\Services\Telephony\Service\Call;

/**
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallInit.php
 */
class OnVoximplantCallInit extends AbstractEventRequest
{
    /**
     * @return \Bitrix24\SDK\Services\Telephony\Requests\Events\Auth
     */
    public function getAuth(): Auth
    {
        return new Auth($this->eventPayload['auth']);
    }

    /**
     * @return \Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallInit\CallData
     */
    public function getCallData(): CallData
    {
        return new CallData($this->eventPayload['data']);
    }
}