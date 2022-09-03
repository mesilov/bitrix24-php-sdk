<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

/**
 * Class ApplicationProfile
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class ApplicationProfile
{
    private const BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID = 'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID';
    private const BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET = 'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET';
    private const BITRIX24_PHP_SDK_APPLICATION_SCOPE = 'BITRIX24_PHP_SDK_APPLICATION_SCOPE';
    private string $clientId;
    private string $clientSecret;
    private Scope $scope;

    /**
     * ApplicationProfile constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param Scope  $scope
     */
    public function __construct(string $clientId, string $clientSecret, Scope $scope)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return Scope
     */
    public function getScope(): Scope
    {
        return $this->scope;
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function initFromArray(array $appProfile): self
    {
        if (!array_key_exists(self::BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID, $appProfile)) {
            throw new InvalidArgumentException(sprintf('in array key %s not found', self::BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID));
        }
        if (!array_key_exists(self::BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET, $appProfile)) {
            throw new InvalidArgumentException(sprintf('in array key %s not found', self::BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET));
        }
        if (!array_key_exists(self::BITRIX24_PHP_SDK_APPLICATION_SCOPE, $appProfile)) {
            throw new InvalidArgumentException(sprintf('in array key %s not found', self::BITRIX24_PHP_SDK_APPLICATION_SCOPE));
        }

        return new self(
            $appProfile[self::BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID],
            $appProfile[self::BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET],
            new Scope(str_replace(' ', '', explode(',', $appProfile[self::BITRIX24_PHP_SDK_APPLICATION_SCOPE]))),
        );
    }
}