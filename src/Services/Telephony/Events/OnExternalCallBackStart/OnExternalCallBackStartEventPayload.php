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

namespace Bitrix24\SDK\Services\Telephony\Events\OnExternalCallBackStart;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;

/**
 * @property-read  non-empty-string $PHONE_NUMBER
 * @property-read  non-empty-string $TEXT
 * @property-read  non-empty-string $VOICE
 * @property-read  CrmEntityType $CRM_ENTITY_TYPE
 * @property-read  string $LINE_NUMBER
 */
class OnExternalCallBackStartEventPayload extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'CRM_ENTITY_ID', => (int)$this->data[$offset],
            'CRM_ENTITY_TYPE' => CrmEntityType::from((string)$this->data[$offset]),
            'IS_MOBILE' => $this->data[$offset] !== '0',
            default => $this->data[$offset] ?? null,
        };
    }
}