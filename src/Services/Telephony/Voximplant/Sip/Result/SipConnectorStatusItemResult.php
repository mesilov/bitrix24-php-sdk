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
use Carbon\CarbonImmutable;

/**
 * @property-read  int $FREE_MINUTES Number of free minutes for integration setup and testing.
 * @property-read  bool $PAID Indicates whether the connector is paid for or not.
 * @property-read  ?CarbonImmutable $PAID_DATE_END Indicates the date through which the connector is paid (if payment was made).
 */
class SipConnectorStatusItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case 'FREE_MINUTES':
                return $this->data[$offset];
            case 'PAID':
                return (bool)$this->data[$offset];
            case 'PAID_DATE_END':
                if ($this->data[$offset] !== '') {
                    return CarbonImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }

                return null;
            default:
                return $this->data[$offset] ?? null;
        }
    }
}