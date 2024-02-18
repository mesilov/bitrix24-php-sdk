<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallStart;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CallType;

/**
 * @property-read string $CALL_ID
 * @property-read int    $USER_ID
 */
class CallData extends AbstractItem
{
    /**
     * @param int|string $offset
     *
     * @return bool|\DateTimeImmutable|int|mixed|null
     */
    public function __get($offset)
    {
        return match ($offset) {
            'USER_ID' => (int)$this->data[$offset],
            default => parent::__get($offset),
        };
    }
}