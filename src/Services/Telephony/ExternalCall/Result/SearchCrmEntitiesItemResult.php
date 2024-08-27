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
        return match ($offset) {
            'CRM_ENTITY_TYPE' => CrmEntityType::from($this->data[$offset]),
            'CRM_ENTITY_ID', 'ASSIGNED_BY_ID' => (int)$this->data[$offset],
            'ASSIGNED_BY' => new UserDigestItemResult($this->data[$offset]),
            default => $this->data[$offset] ?? null,
        };
    }
}