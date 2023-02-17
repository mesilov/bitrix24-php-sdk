<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallEnd;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;
use Bitrix24\SDK\Services\Telephony\Requests\Events\Auth;
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
     * @return \Bitrix24\SDK\Services\Telephony\Requests\Events\Auth
     */
    public function getAuth(): Auth
    {
        return new Auth($this->eventPayload['auth']);
    }

    /**
     * @return \Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallEnd\CallData
     */
    public function getCallData(): CallData
    {
        return new CallData($this->eventPayload['data']);
    }
}