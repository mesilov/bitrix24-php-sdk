<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

interface StatusCodeInterface
{
     const STATUS_OK = 200;
     const STATUS_NOT_MODIFIED = 304;
     const STATUS_DECLINE = 603;
     const STATUS_FORBIDDEN = 403;
     const STATUS_NOT_FOUND = 404;
     const STATUS_BUSY_HERE = 486;
     const STATUS_ADDRESS_INCOMPLETE= 484;
     const STATUS_SERVICE_UNAVAILABLE = 503;
     const STATUS_TEMPORARILY_UNAVAILABLE = 480;
     const STATUS_PAYMENT_REQUIRED = 402;
     const STATUS_INTERVAL_TOO_BRIEF = 423;
}