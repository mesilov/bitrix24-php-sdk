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

namespace Bitrix24\SDK\Services\Telephony\Common;

enum CallFailedCode: int
{
    case successful = 200;
    case missed = 304;
    case declined = 603;
    case prohibited = 403;
    case wrongNumber = 404;
    case unavailable = 486;
    case directionUnavailable = 484;
    case directionUnavailableToo = 503;
    case temporarilyUnavailable = 480;
    case insufficientFundsOnTheAccount = 402;
    case blocked = 423;
}