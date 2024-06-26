<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallStart;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read  non-empty-string $CALL_ID
 * @property-read  int $USER_ID
 * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/events/onvoximplantcallstart.php
 */
class OnVoximplantCallStartEventPayload extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'USER_ID' => (int)$this->data[$offset],
            default => $this->data[$offset] ?? null,
        };
    }
}