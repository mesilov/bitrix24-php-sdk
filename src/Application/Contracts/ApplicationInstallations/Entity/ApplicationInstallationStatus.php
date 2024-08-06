<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity;

enum ApplicationInstallationStatus: string
{
    case new = 'new'; // started the installation procedure, but have not yet finalized, there is no “installation completed”
    case active = 'active'; // active portal, there is a connection to B24
    case deleted = 'deleted'; // the app has been removed from the portal
    case blocked = 'blocked'; // lost connection with the portal or the developer forcibly deactivated the account
}