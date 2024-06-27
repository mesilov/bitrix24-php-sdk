<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalLine\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read  non-empty-string $NUMBER
 * @property-read  non-empty-string|null $NAME
 * @property-read  bool $CRM_AUTO_CREATE
 */
class ExternalLineItemResult extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'CRM_AUTO_CREATE' => $this->data[$offset] === 'Y',
            default => $this->data[$offset] ?? null,
        };
    }
}