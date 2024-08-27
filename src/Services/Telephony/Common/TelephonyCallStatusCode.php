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

enum TelephonyCallStatusCode: int
{
    case successful = 200;
    case missed = 304;
    case prohibited = 403;
    case declined = 603;
    case wrong_number = 404;
    case unavailable = 486;
    case direction_unavailable = 484;
    case direction_unavailable_too = 503;
    case temporarily_unavailable = 480;
    case insufficient_balance = 402;
    case blocked = 423;
}
