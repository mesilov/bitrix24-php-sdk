<?php

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