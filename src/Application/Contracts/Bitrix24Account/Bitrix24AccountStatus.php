<?php

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Account;


enum Bitrix24AccountStatus: string
{
    // started the installation procedure, but have not yet finalized, there is no “installation completed”
    case new = 'new';
    // active portal, there is a connection to B24
    case active = 'active';
    // the app has been removed from the portal
    case deleted = 'deleted';
    // lost connection with the portal or the developer forcibly deactivated the account
    case deactivated = 'deactivated';
}