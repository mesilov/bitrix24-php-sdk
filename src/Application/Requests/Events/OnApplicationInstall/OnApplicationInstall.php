<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events\OnApplicationInstall;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnApplicationInstall extends AbstractEventRequest
{
    public function getApplicationData(): ApplicationData
    {
        return new ApplicationData($this->eventPayload['data']);
    }
}