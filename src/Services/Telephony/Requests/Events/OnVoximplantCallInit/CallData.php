<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallInit;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CallType;

/**
 * @property-read string|null $ACCOUNT_SEARCH_ID Line ID (numeric for leased PBX, regXXX for cloud hosted PBX, and sipXXX for office PBX).
 * @property-read string      $CALL_ID           Call identifier.
 * @property-read string|null $PHONE_NUMBER      Number called by the operator (if call type is: 1 – Outbound) or number called by the subscriber (if call type is: 2 – Inbound).
 * @property-read string      $CALLER_ID         Line identifier (if call type is: 1 – Outbound) or telephone number used to make a call to the portal (if call type is: 2 – Inbound).
 * @property-read int         $REST_APP_ID
 * @property-read CallType    $CALL_TYPE         Call type (see Call Type Description). https://training.bitrix24.com/rest_help/scope_telephony/codes_and_types.php#call_type
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallInit.php
 */
class CallData extends AbstractItem
{
    /**
     * @param int|string $offset
     *
     * @return bool|\DateTimeImmutable|int|mixed|null
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function __get($offset)
    {
        return match ($offset) {
            'CALL_TYPE' => CallType::initByTypeCode((int)$this->data[$offset]),
            'REST_APP_ID' => (int)$this->data[$offset],
            default => parent::__get($offset),
        };
    }
}