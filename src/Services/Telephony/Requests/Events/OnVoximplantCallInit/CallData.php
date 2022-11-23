<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnVoximplantCallInit;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CallType;

/**
 * @property-read string   $CALL_ID
 * @property-read string   $CALLER_ID
 * @property-read int      $REST_APP_ID
 * @property-read CallType $CALL_TYPE
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