<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\User;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\User\Service\User;

class UserServiceBuilder extends AbstractServiceBuilder
{
    /**
     * get user service
     *
     * @return User
     */
    public function user(): User
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new User($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}