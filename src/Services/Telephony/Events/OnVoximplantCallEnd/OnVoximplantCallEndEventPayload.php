<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallEnd;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CallFailedCode;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Carbon\CarbonImmutable;
use Money\Currency;
use Money\Money;

/**
 * @property-read  non-negative-int $CALL_DURATION
 * @property-read  CallFailedCode $CALL_FAILED_CODE
 * @property-read  ?string $CALL_FAILED_REASON
 * @property-read  non-empty-string $CALL_ID
 * @property-read  CarbonImmutable $CALL_START_DATE
 * @property-read  CallType $CALL_TYPE
 * @property-read  Currency $COST_CURRENCY
 * @property-read  Money $COST
 * @property-read  non-negative-int $CRM_ACTIVITY_ID
 * @property-read  non-empty-string $PHONE_NUMBER
 * @property-read  non-empty-string $PORTAL_NUMBER
 * @property-read  non-negative-int $PORTAL_USER_ID
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallend.php
 */
class OnVoximplantCallEndEventPayload extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'CALL_DURATION', 'CRM_ACTIVITY_ID', 'PORTAL_USER_ID' => (int)$this->data[$offset],
            'CALL_FAILED_CODE' => CallFailedCode::from((int)$this->data[$offset]),
            'CALL_START_DATE' => CarbonImmutable::parse($this->data[$offset]),
            'CALL_TYPE' => CallType::from((int)$this->data[$offset]),
            'COST_CURRENCY' => new Currency((string)$this->data[$offset]),
            'COST' => $this->decimalMoneyParser->parse((string)$this->data[$offset], new Currency($this->data['COST_CURRENCY'])),
            default => $this->data[$offset] ?? null,
        };
    }
}