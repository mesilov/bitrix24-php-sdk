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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\User\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read  int $ID User ID
 * @property-read  non-empty-string|null $DEFAULT_LINE
 * @property-read  bool $PHONE_ENABLED
 * @property-read  non-empty-string $SIP_SERVER
 * @property-read  non-empty-string $SIP_LOGIN
 * @property-read  non-empty-string|null $SIP_PASSWORD
 * @property-read  non-empty-string $INNER_NUMBER
 */
class VoximplantUserSettingsItemResult extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'ID' => (int)$this->data[$offset],
            'PHONE_ENABLED' => (bool)$this->data[$offset],
            default => $this->data[$offset] ?? null,
        };
    }
}