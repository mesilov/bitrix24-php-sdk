<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\ApplicationBridge;


use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Events\AuthTokenRenewedEvent;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Filesystem\Filesystem;

readonly class ApplicationCredentialsProvider
{
    public function __construct(private AccessTokenRepositoryInterface $repository)
    {
    }

    public function isCredentialsAvailable(): bool
    {
        return $this->repository->isAvailable();
    }

    public function saveAccessToken(AccessToken $accessToken): void
    {
        $this->repository->saveAccessToken($accessToken);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCredentials(ApplicationProfile $applicationProfile, string $domainUrl): Credentials
    {
        return new Credentials(
            null,
            $this->repository->getAccessToken(),
            $applicationProfile,
            $domainUrl
        );
    }

    #[NoReturn]
    public function onAuthTokenRenewedEventListener(AuthTokenRenewedEvent $event): void
    {
        // update credentials
        $this->repository->saveRenewedAccessToken($event->getRenewedToken());
    }

    public static function buildProviderForLocalApplication(): self
    {
        return new ApplicationCredentialsProvider(new AccessTokenFileStorage(new Filesystem()));
    }
}