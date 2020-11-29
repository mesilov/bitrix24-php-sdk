<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

/**
 * Class Main
 *
 * @package Bitrix24\SDK\Services
 */
class Main extends AbstractService
{
    public function getAvailableMethods(): array
    {
        return $this->core->call('methods', [])->getResponseData()->getResult()->getResultData();
    }

    public function getAllMethods(): array
    {
        return $this->core->call('methods', ['full' => true])->getResponseData()->getResult()->getResultData();
    }

    public function getMethodsByScope(string $scopeName): array
    {
        return $this->core->call('methods', ['scope' => $scopeName])->getResponseData()->getResult()->getResultData();
    }

    public function getApplicationInfo(): array
    {
        return $this->core->call('app.info')->getResponseData()->getResult()->getResultData();
    }

    public function isCurrentUserHasAdminRights(): bool
    {
        return $this->core->call('user.admin')->getResponseData()->getResult()->getResultData()[0];
    }

    public function getUserProfile(): array
    {
        return $this->core->call('profile')->getResponseData()->getResult()->getResultData();
    }
}