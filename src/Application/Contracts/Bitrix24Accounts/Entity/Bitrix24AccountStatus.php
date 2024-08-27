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

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity;

enum Bitrix24AccountStatus: string
{
    case new = 'new'; // started the installation procedure, but have not yet finalized, there is no “installation completed”
    case active = 'active'; // active portal, there is a connection to B24
    case deleted = 'deleted'; // the app has been removed from the portal
    case blocked = 'blocked'; // lost connection with the portal or the developer forcibly deactivated the account
}