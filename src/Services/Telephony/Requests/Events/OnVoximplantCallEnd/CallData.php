<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallEnd;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

/**
 * @property-read string             $CALL_ID                                     Call identifier.
 * @property-read int                $CALL_DURATION                               Call duration.
 * @property-read int                $CALL_FAILED_CODE                            Call code (See Call Code Table). https://training.bitrix24.com/rest_help/scope_telephony/codes_and_types.php#call_failed_code
 * @property-read string             $CALL_FAILED_REASON                          Call code textual description (Latin letters).
 * @property-read \DateTimeImmutable $CALL_START_DATE                             Date in ISO format.
 * @property-read CallType           $CALL_TYPE                                   Call type (see Call Type Description). https://training.bitrix24.com/rest_help/scope_telephony/codes_and_types.php#call_type
 * @property-read \Money\Currency    $COST_CURRENCY                               Currency of the call (RUR, USD, EUR).
 * @property-read \Money\Money       $COST                                        Call cost.
 * @property-read int                $CRM_ACTIVITY_ID                             CRM activity id
 * @property-read string             $PHONE_NUMBER                                Number used by the subscriber to make a call (if call type is: 2 – Inbound) or number called by the operator (if call type is: 1 – Outbound).
 * @property-read string             $PORTAL_NUMBER                               Number receiving the call (if call type is: 2 – Inbound) or number from which the call was made (if call type is: 1 – Outbound).
 * @property-read int                $PORTAL_USER_ID                              Responding operator ID (if call type is: 2 – Inbound) or identifier of the calling operator (if call type is: 1 – Outbound).
 *
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallend.php
 */
class CallData extends AbstractItem
{
    /**
     * @param int|string $offset
     *
     * @return bool|\DateTimeImmutable|int|mixed|null
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Exception
     */
    public function __get($offset)
    {
        switch ($offset) {
            case 'CALL_ID':
                return (string)$this->data[$offset];
            case 'CALL_START_DATE':
                return new \DateTimeImmutable((string)$this->data[$offset]);
            case 'CALL_TYPE':
                return CallType::initByTypeCode((int)$this->data[$offset]);
            case 'CALL_DURATION':
            case 'CALL_FAILED_CODE':
            case 'CRM_ACTIVITY_ID':
            case 'PORTAL_USER_ID':
                return (int)$this->data[$offset];
            case 'COST_CURRENCY':
                return new Currency($this->data[$offset]);
            case 'COST':
                if ($this->data[$offset] === null) {
                    return new Money(0, new Currency($this->data['COST_CURRENCY']));
                }

                return (new DecimalMoneyParser(new ISOCurrencies()))->parse(
                    $this->data[$offset],
                    new Currency($this->data['COST_CURRENCY'])
                );
            default:
                return parent::__get($offset);
        }
    }
}