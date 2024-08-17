<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity;

/**
 * @see https://training.bitrix24.com/rest_help/crm/auxiliary/enum/crm_enum_contenttype.php
 */
enum ActivityContentType: int
{
    case default = 0;
    case plainText = 1;
    case bbCode = 2;
    case html = 3;
}