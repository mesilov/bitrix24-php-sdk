<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\ApplicationBridge;

use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Exceptions\FileNotFoundException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken;
use JsonException;
use Symfony\Component\Filesystem\Filesystem;

readonly class AccessTokenFileStorage implements AccessTokenRepositoryInterface
{
    private const TOKEN_FILE_NAME = 'auth.json';

    public function __construct(
        private Filesystem $filesystem)
    {
    }

    private function getFileName(): string
    {
        return dirname(__DIR__, 2) . '/tests/ApplicationBridge/' . self::TOKEN_FILE_NAME;
    }

    public function isAvailable(): bool
    {
        return $this->filesystem->exists($this->getFileName());
    }

    /**
     * @throws FileNotFoundException
     * @throws JsonException
     */
    public function getAccessToken(): AccessToken
    {
        if (!$this->filesystem->exists($this->getFileName())) {
            throw new FileNotFoundException(sprintf('file «%s» with stored access token not found', $this->getFileName()));
        }

        $payload = file_get_contents($this->getFileName());
        return AccessToken::initFromArray(json_decode($payload, true, 512, JSON_THROW_ON_ERROR));
    }

    public function saveAccessToken(AccessToken $accessToken): void
    {
        $accessTokenPayload = json_encode([
            'access_token' => $accessToken->getAccessToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires()
        ], JSON_THROW_ON_ERROR);

        $this->filesystem->dumpFile($this->getFileName(), $accessTokenPayload);
    }

    public function saveRenewedAccessToken(RenewedAccessToken $renewedAccessToken): void
    {
        $this->saveAccessToken($renewedAccessToken->getAccessToken());
    }
}