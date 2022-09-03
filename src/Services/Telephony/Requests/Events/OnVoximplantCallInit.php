<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;
use Bitrix24\SDK\Services\Telephony\Common\CallType;

/**
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallInit.php
 */
class OnVoximplantCallInit extends AbstractEventRequest
{
    /**
     * @return string Call identifier.
     */
    public function getCallId(): string
    {
        return $this->eventPayload['data']['CALL_ID'];
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function getCallType(): CallType
    {
        return CallType::initByTypeCode((int)$this->eventPayload['data']['CALL_TYPE']);
    }

    /**
     * @return string Line ID (numeric for leased PBX, regXXX for cloud hosted PBX, and sipXXX for office PBX).
     */
    public function getAccountSearchId(): string
    {
        return $this->eventPayload['data']['ACCOUNT_SEARCH_ID'];
    }

    /**
     * @return string Number called by the operator (if call type is: 1 – Outbound) or number called by the subscriber (if call type is: 2 – Inbound).
     */
    public function getPhoneNumber(): string
    {
        return $this->eventPayload['data']['PHONE_NUMBER'];
    }

    /**
     * @return string Line identifier (if call type is: 1 – Outbound) or telephone number used to make a call to the portal (if call type is: 2 – Inbound).
     */
    public function getCallerId(): string
    {
        return $this->eventPayload['data']['CALLER_ID'];
    }
}