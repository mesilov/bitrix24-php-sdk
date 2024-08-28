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
use Bitrix24\SDK\Core\Exceptions\FileNotFoundException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use JsonException;
use Symfony\Component\Filesystem\Filesystem;

readonly class AuthTokenFileStorage implements AuthTokenRepositoryInterface
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
    public function getToken(): AuthToken
    {
        if (!$this->filesystem->exists($this->getFileName())) {
            throw new FileNotFoundException(sprintf('file «%s» with stored access token not found', $this->getFileName()));
        }

        $payload = file_get_contents($this->getFileName());
        return AuthToken::initFromArray(json_decode($payload, true, 512, JSON_THROW_ON_ERROR));
    }

    /**
     * @throws JsonException
     */
    public function saveToken(AuthToken $authToken): void
    {
        $tokenPayload = json_encode([
            'access_token' => $authToken->getAccessToken(),
            'refresh_token' => $authToken->getRefreshToken(),
            'expires' => $authToken->getExpires()
        ], JSON_THROW_ON_ERROR);

        $this->filesystem->dumpFile($this->getFileName(), $tokenPayload);
    }

    public function saveRenewedToken(RenewedAuthToken $renewedAuthToken): void
    {
        $this->saveToken($renewedAuthToken->authToken);
    }
}