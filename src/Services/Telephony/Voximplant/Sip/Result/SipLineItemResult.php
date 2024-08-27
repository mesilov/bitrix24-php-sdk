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
use Money\Currency;
use Money\Money;

/**
 * @property-read  int $ID
 * @property-read  PbxType $TYPE PBX type
 * @property-read  int $CONFIG_ID SIP line setup identifier.
 * @property-read  int $REG_ID SIP registration identifier (for cloud hosted PBX only).
 * @property-read  non-empty-string $SERVER SIP registration server address for cloud hosted PBX or server address for office PBX.
 * @property-read  non-empty-string $LOGIN Server login.
 * @property-read  non-empty-string $PASSWORD Server password.
 * @property-read  mixed $AUTH_USER
 * @property-read  mixed $OUTBOUND_PROXY
 * @property-read  mixed $DETECT_LINE_NUMBER
 * @property-read  string $LINE_DETECT_HEADER_ORDER
 * @property-read  mixed $REGISTRATION_STATUS_CODE
 * @property-read  mixed $REGISTRATION_ERROR_MESSAGE
 * @property-read  non-empty-string $TITLE
 */
class SipLineItemResult extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'ID', 'REG_ID', 'CONFIG_ID' => (int)$this->data[$offset],
            'TYPE' => PbxType::from($this->data[$offset]),
            default => $this->data[$offset] ?? null,
        };
    }
}