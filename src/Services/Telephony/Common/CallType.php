<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

enum CallType: int
{
    case outbound = 1;
    case inbound = 2;
    case inboundWithRedirect = 3;
    case callback = 4;
}
