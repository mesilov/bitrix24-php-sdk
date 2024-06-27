<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\ApplicationBridge;


use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken;

interface AccessTokenRepositoryInterface
{
    public function getAccessToken(): AccessToken;

    public function saveRenewedAccessToken(RenewedAccessToken $renewedAccessToken): void;

    public function saveAccessToken(AccessToken $accessToken): void;

    public function isAvailable():bool;
}