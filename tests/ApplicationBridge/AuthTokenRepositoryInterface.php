<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\ApplicationBridge;


use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;

interface AuthTokenRepositoryInterface
{
    public function getToken(): AuthToken;

    public function saveRenewedToken(RenewedAuthToken $renewedAuthToken): void;

    public function saveToken(AuthToken $authToken): void;

    public function isAvailable():bool;
}