<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events\OnExternalCallStart;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CallType;

/**
 * @property-read string      $CALL_ID
 * @property-read int         $CALL_LIST_ID
 * @property-read array|null  $CRM_CREATED_ENTITIES
 * @property-read int         $CRM_CREATED_LEAD
 * @property-read int         $CRM_ENTITY_ID
 * @property-read string|null $CRM_ENTITY_TYPE
 * @property-read string|null $EXTENSION
 * @property-read bool        $IS_MOBILE
 * @property-read string|null $LINE_NUMBER
 * @property-read string      $PHONE_NUMBER_INTERNATIONAL
 * @property-read string      $PHONE_NUMBER
 * @property-read int         $USER_ID
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
            'IS_MOBILE' => (int)$this->data[$offset] !== 0,
            'CALL_TYPE' => CallType::initByTypeCode((int)$this->data[$offset]),
            'CRM_ENTITY_TYPE' => (string)$this->data[$offset],
            'REST_APP_ID', 'CALL_LIST_ID', 'CRM_CREATED_LEAD', 'CRM_ENTITY_ID', 'USER_ID' => (int)$this->data[$offset],
            default => parent::__get($offset),
        };
    }
}