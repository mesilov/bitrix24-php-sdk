<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;

/**
 * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/events_telephony/index.php
 */
class OnExternalCallStart extends AbstractEventRequest
{
    /**
     * @return int The user ID.
     */
    public function getUserId(): int
    {
        return (int)$this->eventPayload['USER_ID'];
    }

    /**
     * @return string Outbound call ID.
     */
    public function getPhoneNumber(): string
    {
        return $this->eventPayload['PHONE_NUMBER'];
    }

    /**
     * @return string
     */
    public function getPhoneNumberInternational(): string
    {
        return $this->eventPayload['PHONE_NUMBER_INTERNATIONAL'];
    }

    /**
     * @return \Bitrix24\SDK\Services\Telephony\Common\CrmEntityType
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function getCrmEntityType(): CrmEntityType
    {
        return CrmEntityType::initByCode($this->eventPayload['CRM_ENTITY_TYPE']);
    }

    /**
     * @return int The CRM object ID, which type is specified in CRM_ENTITY_TYPE.
     */
    public function getCrmEntityId(): int
    {
        return (int)$this->eventPayload['CRM_ENTITY_ID'];
    }

    /**
     * @return int Call list ID, if the call is made from the call list.
     */
    public function getCallListId(): int
    {
        return (int)$this->eventPayload['CALL_LIST_ID'];
    }

    /**
     * @return string External line number, via which the the call is requested.
     */
    public function getLineNumber(): string
    {
        return $this->eventPayload['LINE_NUMBER'];
    }

    /**
     * @return string Call ID from the telephony.externalcall.register method.
     */
    public function getCallId(): string
    {
        return $this->eventPayload['CALL_ID'];
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->eventPayload['EXTENSION'];
    }

    /**
     * @return bool Defines call as initiated from the mobile app.
     */
    public function isMobile(): bool
    {
        return !($this->eventPayload['IS_MOBILE'] === '0');
    }
}