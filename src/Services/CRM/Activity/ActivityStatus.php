<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity;

/**
 * @see https://training.bitrix24.com/rest_help/crm/auxiliary/enum/crm_enum_activitystatus.php
 */
enum ActivityStatus: int
{
    case default = 0;
    case waiting = 1;
    case finished = 2;
    case finishedAutomatically = 3;
}