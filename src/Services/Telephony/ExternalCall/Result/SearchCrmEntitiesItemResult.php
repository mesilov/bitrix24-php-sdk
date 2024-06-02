<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;

/**
 * @property-read CrmEntityType $CRM_ENTITY_TYPE
 * @property-read int $CRM_ENTITY_ID
 * @property-read int $ASSIGNED_BY_ID
 * @property-read string $NAME
 * @property-read UserDigestItemResult $ASSIGNED_BY
 */
class SearchCrmEntitiesItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case'CRM_ENTITY_TYPE':
                return CrmEntityType::from($this->data[$offset]);
            case 'CRM_ENTITY_ID':
            case 'ASSIGNED_BY_ID':
                return (int)$this->data[$offset];
            case 'ASSIGNED_BY':
                return new UserDigestItemResult($this->data[$offset]);
            default:
                return $this->data[$offset] ?? null;
        }
    }
}