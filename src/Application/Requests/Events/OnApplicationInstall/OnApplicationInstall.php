<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events\OnApplicationInstall;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnApplicationInstall extends AbstractEventRequest
{
    /**
     * @return \Bitrix24\SDK\Application\Requests\Events\OnApplicationInstall\ApplicationData
     */
    public function getApplicationData(): ApplicationData
    {
        return new ApplicationData($this->eventPayload['data']);
    }

    /**
     * @return \Bitrix24\SDK\Application\Requests\Events\OnApplicationInstall\Auth
     */
    public function getAuth(): Auth
    {
        return new Auth($this->eventPayload['auth']);
    }
}