<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallEnd;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class
OnVoximplantCallEnd extends AbstractEventRequest
{
    public const CODE = 'ONVOXIMPLANTCALLEND';
}