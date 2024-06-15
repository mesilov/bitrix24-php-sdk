<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

enum TranscriptMessageSide: string
{
    case user = 'User';
    case client = 'Client';
}