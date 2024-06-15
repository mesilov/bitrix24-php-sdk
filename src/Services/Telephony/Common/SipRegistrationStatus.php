<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

enum SipRegistrationStatus: string
{
    case success = 'success';
    case error = 'error';
    case inProgress = 'in_progress';
    case wait = 'wait';
}