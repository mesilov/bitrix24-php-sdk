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
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Events\AuthTokenRenewedEvent;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Filesystem\Filesystem;

readonly class ApplicationCredentialsProvider
{
    public function __construct(private AuthTokenRepositoryInterface $repository)
    {
    }

    public function isCredentialsAvailable(): bool
    {
        return $this->repository->isAvailable();
    }

    public function saveAuthToken(AuthToken $authToken): void
    {
        $this->repository->saveToken($authToken);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCredentials(ApplicationProfile $applicationProfile, string $domainUrl): Credentials
    {
        return new Credentials(
            null,
            $this->repository->getToken(),
            $applicationProfile,
            $domainUrl
        );
    }

    #[NoReturn]
    public function onAuthTokenRenewedEventListener(AuthTokenRenewedEvent $event): void
    {
        // update credentials
        $this->repository->saveRenewedToken($event->getRenewedToken());
    }

    public static function buildProviderForLocalApplication(): self
    {
        return new ApplicationCredentialsProvider(new AuthTokenFileStorage(new Filesystem()));
    }
}