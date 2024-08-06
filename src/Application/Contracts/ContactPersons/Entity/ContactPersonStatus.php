<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ContactPersons\Entity;

enum ContactPersonStatus: string
{
    case active = 'active'; // active contact person
    case deleted = 'deleted'; // the app has been removed from the portal
    case blocked = 'blocked'; // developer forcibly deactivated the account
}