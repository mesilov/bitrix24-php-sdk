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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntity;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\Common\SipRegistrationStatus;
use Carbon\CarbonImmutable;
use Money\Currency;
use Money\Money;

/**
 * @property-read  int $REG_ID SIP registration identifier (for cloud hosted PBX only).
 * @property-read  CarbonImmutable $LAST_UPDATED Date of the last change of SIP registration.
 * @property-read  non-empty-string|null $ERROR_MESSAGE Error code textual description.
 * @property-read  non-empty-string|null $STATUS_CODE Error numeric code.
 * @property-read  SipRegistrationStatus $STATUS_RESULT SIP registration status
 */
class SipLineStatusItemResult extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'REG_ID' => (int)$this->data[$offset],
            'LAST_UPDATED' => CarbonImmutable::createFromTimeString($this->data[$offset]),
            'STATUS_RESULT' => SipRegistrationStatus::from($this->data[$offset]),
            default => $this->data[$offset] ?? null,
        };
    }
}