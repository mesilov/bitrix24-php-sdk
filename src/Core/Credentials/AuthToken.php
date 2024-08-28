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

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\HttpFoundation;

class AuthToken
{
    public function __construct(
        protected string  $accessToken,
        protected ?string $refreshToken,
        protected int     $expires,
        protected ?int    $expiresIn = null)
    {
    }

    /**
     * Is this one-off token from event
     *
     * One-off tokens do not have refresh token field
     */
    public function isOneOff(): bool
    {
        return $this->refreshToken === null;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function getExpires(): int
    {
        return $this->expires;
    }

    public function hasExpired(): bool
    {
        return $this->getExpires() <= time();
    }


    public static function initFromArray(array $request): self
    {
        return new self(
            (string)$request['access_token'],
            (string)$request['refresh_token'],
            (int)$request['expires']
        );
    }

    public static function initFromWorkflowRequest(HttpFoundation\Request $request): self
    {
        $requestFields = $request->request->all();
        return self::initFromArray($requestFields['auth']);
    }

    public static function initFromEventRequest(HttpFoundation\Request $request): self
    {
        $requestFields = $request->request->all();
        return new self(
            $requestFields['auth']['access_token'],
            null,
            (int)$requestFields['auth']['expires'],
            (int)$requestFields['auth']['expires_in'],
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function initFromPlacementRequest(HttpFoundation\Request $request): self
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