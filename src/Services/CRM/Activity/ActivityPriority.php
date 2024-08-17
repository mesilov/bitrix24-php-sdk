<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity;

/**
 * @see https://training.bitrix24.com/rest_help/crm/auxiliary/enum/crm_enum_activitypriority.php
 */
enum ActivityPriority: int
{
    case default = 0;
    case low = 1;
    case medium = 2;
    case high = 3;
}