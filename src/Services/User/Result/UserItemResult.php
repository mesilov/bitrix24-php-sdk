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

namespace Bitrix24\SDK\Services\User\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Carbon\CarbonImmutable;

/**
 * @property-read int $ID
 * @property-read string $XML_ID
 * @property-read bool $ACTIVE
 * @property-read string $NAME
 * @property-read string $LAST_NAME
 * @property-read string $SECOND_NAME
 * @property-read string $TITLE
 * @property-read string $EMAIL
 * @property-read CarbonImmutable $LAST_LOGIN
 * @property-read CarbonImmutable $DATE_REGISTER
 * @property-read string $TIME_ZONE
 * @property-read bool $IS_ONLINE
 * @property-read int $TIME_ZONE_OFFSET
 * @property-read array $TIMESTAMP_X
 * @property-read array $LAST_ACTIVITY_DATE
 * @property-read string $PERSONAL_GENDER
 * @property-read string $PERSONAL_WWW
 * @property-read CarbonImmutable $PERSONAL_BIRTHDAY
 * @property-read string $PERSONAL_PHOTO
 * @property-read string $PERSONAL_MOBILE
 * @property-read string $PERSONAL_CITY
 * @property-read string $WORK_PHONE
 * @property-read CarbonImmutable $UF_EMPLOYMENT_DATE
 * @property-read string $UF_TIMEMAN
 * @property-read array $UF_DEPARTMENT
 * @property-read string $UF_PHONE_INNER
 * @property-read string $USER_TYPE
 */
class UserItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case 'ID':
            case 'TIME_ZONE_OFFSET':
                return (int)$this->data[$offset];
            case 'LAST_LOGIN':
            case 'DATE_REGISTER':
            case 'UF_EMPLOYMENT_DATE':
            case 'PERSONAL_BIRTHDAY':
                if ($this->data[$offset] !== '') {
                    return CarbonImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }

                break;
            case 'IS_ONLINE':
                return $this->data[$offset] === 'Y';
        }

        return $this->data[$offset] ?? null;
    }
}