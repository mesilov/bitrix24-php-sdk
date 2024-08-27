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

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * Class ApplicationInfoResult
 *
 * @property-read boolean $ADMIN
 * @property-read int     $ID
 * @property-read string  $LAST_NAME
 * @property-read string  $NAME
 * @property-read string  $PERSONAL_GENDER
 * @property-read string  $PERSONAL_PHOTO
 * @property-read string  $TIME_ZONE
 * @property-read int     $TIME_ZONE_OFFSET
 * @property-read string  $STATUS
 */
class UserProfileItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case 'ID':
                if ($this->data[$offset] !== '' && $this->data[$offset] !== null) {
                    return (int)$this->data[$offset];
                }

                return null;
            default:
                return parent::__get($offset);
        }
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function getStatus(): ?ApplicationStatus
    {
        return $this->STATUS !== null ? new ApplicationStatus($this->STATUS) : null;
    }
}