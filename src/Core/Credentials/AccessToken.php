<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

/**
 * Class AccessToken
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class AccessToken
{
    /**
     * @var string
     */
    protected $accessToken;
    /**
     * @var string
     */
    protected $refreshToken;
    /**
     * @var int
     */
    protected $expires;

    /**
     * AccessToken constructor.
     *
     * @param string $accessToken
     * @param string $refreshToken
     * @param int    $expires
     */
    public function __construct(string $accessToken, string $refreshToken, int $expires)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->expires = $expires;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return int
     */
    public function getExpires(): int
    {
        return $this->expires;
    }

    /**
     * @return bool
     */
    public function hasExpired(): bool
    {
        return $this->getExpires() <= time();
    }

    /**
     * @param array $request
     *
     * @return static
     */
    public static function initFromArray(array $request): self
    {
        return new self(
            (string)$request['access_token'],
            (string)$request['refresh_token'],
            (int)$request['expires']
        );
    }
}