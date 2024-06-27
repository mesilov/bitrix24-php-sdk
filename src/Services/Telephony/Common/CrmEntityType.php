<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

enum CrmEntityType: string
{
    case contact = 'CONTACT';
    case company = 'COMPANY';
    case lead = 'LEAD';
}
