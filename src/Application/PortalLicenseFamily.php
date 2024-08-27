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

namespace Bitrix24\SDK\Application;

/**
 * Portal license family enum
 * @link https://training.bitrix24.com/rest_help/general/app_info.php
 */
enum PortalLicenseFamily: string
{
    case free = 'free';
    case basic = 'basic';
    case std = 'std';
    case pro = 'pro';
    case en = 'en';
    case nfr = 'nfr';
}