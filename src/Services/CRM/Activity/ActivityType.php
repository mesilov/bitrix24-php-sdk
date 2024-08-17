<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity;

/**
 * @see https://training.bitrix24.com/rest_help/crm/auxiliary/enum/crm_enum_activitytype.php
 */
enum ActivityType: int
{
    case default = 0;
    case meeting = 1;
    case call = 2;
    case task = 3;
    case letter = 4;
    case action = 5;
    case userAction = 6;
}