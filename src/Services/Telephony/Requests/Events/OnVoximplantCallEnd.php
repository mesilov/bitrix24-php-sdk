<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use DateTimeImmutable;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

/**
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallend.php
 */
class OnVoximplantCallEnd extends AbstractEventRequest
{
    /**
     * @return string Call identifier.
     */
    public function getCallId(): string
    {
        return $this->eventPayload['CALL_ID'];
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function getCallType(): CallType
    {
        return CallType::initByTypeCode((int)$this->eventPayload['CALL_TYPE']);
    }

    /**
     * @return string Number used by the subscriber to make a call (if call type is: 2 – Inbound) or number called by the operator (if call type is: 1 – Outbound).
     */
    public function getPhoneNumber(): string
    {
        return $this->eventPayload['PHONE_NUMBER'];
    }

    /**
     * @return string Number receiving the call (if call type is: 2 – Inbound) or number from which the call was made (if call type is: 1 – Outbound).
     */
    public function getPortalNumber(): string
    {
        return $this->eventPayload['PORTAL_NUMBER'];
    }

    /**
     * @return int Responding operator ID (if call type is: 2 – Inbound) or identifier of the calling operator (if call type is: 1 – Outbound).
     */
    public function getPortalUserId(): int
    {
        return (int)$this->eventPayload['PORTAL_USER_ID'];
    }

    /**
     * @return int Call duration.
     */
    public function getCallDuration(): int
    {
        return (int)$this->eventPayload['CALL_DURATION'];
    }

    /**
     * @return \DateTimeImmutable Date in ISO format.
     */
    public function getCallStartDate(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(DATE_ATOM, $this->eventPayload['CALL_START_DATE']);
    }

    /**
     * @return \Money\Money Call cost.
     */
    public function getCost(): Money
    {
        if ($this->eventPayload['COST'] === '') {
            return new Money(0, new Currency($this->eventPayload['COST_CURRENCY']));
        }

        return (new DecimalMoneyParser(new ISOCurrencies()))->parse(
            $this->eventPayload['COST'],
            $this->eventPayload['COST_CURRENCY']
        );
    }

    /**
     * @return int Call code (See Call Code Table).
     */
    public function getCallFailedCode(): int
    {
        return (int)$this->eventPayload['CALL_FAILED_CODE'];
    }

    /**
     * @return string Call code textual description (Latin letters).
     */
    public function getCallFailedReason(): string
    {
        return $this->eventPayload['CALL_FAILED_REASON'];
    }

    /**
     * @return int
     */
    public function getCrmActivityId(): int
    {
        return (int)$this->eventPayload['CRM_ACTIVITY_ID'];
    }
}