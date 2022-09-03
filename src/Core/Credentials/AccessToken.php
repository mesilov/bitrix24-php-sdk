<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AccessToken
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class AccessToken
{
    protected string $accessToken;
    protected string $refreshToken;
    protected int $expires;

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
     * @return self
     */
    public static function initFromArray(array $request): self
    {
        return new self(
            (string)$request['access_token'],
            (string)$request['refresh_token'],
            (int)$request['expires']
        );
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function initFromPlacementRequest(Request $request): self
    {
        $requestFields = $request->request->all();
        if (!array_key_exists('AUTH_ID', $requestFields)) {
            throw new InvalidArgumentException('field AUTH_ID not fount in request');
        }
        if (!array_key_exists('REFRESH_ID', $requestFields)) {
            throw new InvalidArgumentException('field REFRESH_ID not fount in request');
        }
        if (!array_key_exists('AUTH_EXPIRES', $requestFields)) {
            throw new InvalidArgumentException('field AUTH_EXPIRES not fount in request');
        }

        return new self(
            (string)$request->request->get('AUTH_ID'),
            (string)$request->request->get('REFRESH_ID'),
            $request->request->getInt('AUTH_EXPIRES'),
        );
    }
}