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

namespace Bitrix24\SDK\Application\Contracts\ContactPersons\Entity;

enum ContactPersonStatus: string
{
    case active = 'active'; // active contact person
    case deleted = 'deleted'; // the app has been removed from the portal
    case blocked = 'blocked'; // developer forcibly deactivated the account
}