<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

/**
 * Class OAuthToken
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class OAuthToken
{
    protected string $authToken;
    protected string $refreshToken;
    protected int $expiresIn;

    /**
     * OAuthToken constructor.
     *
     * @param string $authToken
     * @param string $refreshToken
     * @param int    $expiresIn
     */
    public function __construct(string $authToken, string $refreshToken, int $expiresIn)
    {
        $this->authToken = $authToken;
        $this->refreshToken = $refreshToken;
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
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
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }
}