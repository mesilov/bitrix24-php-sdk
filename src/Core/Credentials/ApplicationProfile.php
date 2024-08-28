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

    /**
     * ApplicationProfile constructor.
     */
    public function __construct(private readonly string $clientId, private readonly string $clientSecret, private readonly Scope $scope)
    {
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

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
            new Scope(str_replace(' ', '', explode(',', (string) $appProfile[self::BITRIX24_PHP_SDK_APPLICATION_SCOPE]))),
        );
    }
}