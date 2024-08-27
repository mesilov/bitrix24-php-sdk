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

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity;

enum Bitrix24PartnerStatus: string
{
    case active = 'active';     // active bitrix24 partner
    case deleted = 'deleted';   // partner was deleted
    case blocked = 'blocked';   // partner was blocked
}