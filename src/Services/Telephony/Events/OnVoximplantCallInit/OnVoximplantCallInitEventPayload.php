<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallInit;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CallType;

/**
 * @property-read  non-empty-string $CALL_ID
 * @property-read  CallType $CALL_TYPE
 * @property-read  non-empty-string $CALLER_ID
 * @property-read  non-negative-int $REST_APP_ID
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallInit.php
 */
class OnVoximplantCallInitEventPayload extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'USER_ID', 'REST_APP_ID' => (int)$this->data[$offset],
            'CALL_TYPE' => CallType::from((int)$this->data[$offset]),
            default => $this->data[$offset] ?? null,
        };
    }
}