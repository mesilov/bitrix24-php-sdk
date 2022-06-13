<?php

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
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function getStatus(): ?ApplicationStatus
    {
        return $this->STATUS !== null ? new ApplicationStatus($this->STATUS) : null;
    }
}