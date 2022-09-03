<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events\OnApplicationUninstall;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnApplicationUninstall extends AbstractEventRequest
{
    /**
     * @return \Bitrix24\SDK\Application\Requests\Events\OnApplicationUninstall\ApplicationData
     */
    public function getApplicationData(): ApplicationData
    {
        return new ApplicationData($this->eventPayload['data']);
    }

    /**
     * @return \Bitrix24\SDK\Application\Requests\Events\OnApplicationUninstall\Auth
     */
    public function getAuth(): Auth
    {
        return new Auth($this->eventPayload['auth']);
    }
}