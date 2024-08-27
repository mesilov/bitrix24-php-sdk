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
 * @property-read int     $ID
 * @property-read string  $CODE
 * @property-read array   $SCOPE
 * @property-read int     $VERSION
 * @property-read string  $STATUS
 * @property-read boolean $INSTALLED
 * @property-read string  $PAYMENT_EXPIRED
 * @property-read int     $DAYS
 * @property-read string  $LICENSE
 */
class ApplicationInfoItemResult extends AbstractItem
{
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function getStatus(): ?ApplicationStatus
    {
        return $this->STATUS !== null ? new ApplicationStatus($this->STATUS) : null;
    }
}