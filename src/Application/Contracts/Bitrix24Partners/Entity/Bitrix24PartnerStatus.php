<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity;

enum Bitrix24PartnerStatus: string
{
    case active = 'active';     // active bitrix24 partner
    case deleted = 'deleted';   // partner was deleted
    case blocked = 'blocked';   // partner was blocked
}