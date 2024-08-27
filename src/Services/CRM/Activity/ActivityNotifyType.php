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

namespace Bitrix24\SDK\Services\CRM\Activity;

/**
 * @see https://training.bitrix24.com/rest_help/crm/auxiliary/enum/crm_enumactivitynotifytype.php
 */
enum ActivityNotifyType: int
{
    case default = 0;
    case minutes = 1;
    case hours = 2;
    case days = 3;
}