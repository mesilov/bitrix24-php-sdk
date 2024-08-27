<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

readonly class Endpoints
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        /**
         * @phpstan-param non-empty-string $authServerUrl
         */
        public string $authServerUrl,
        /**
         * @phpstan-param non-empty-string $clientUrl
         */
        public string $clientUrl,
    )
    {
        if (filter_var($authServerUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(sprintf('authServer endpoint URL «%s» is invalid', $authServerUrl));
        }

        if (filter_var($clientUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(sprintf('client endpoint URL «%s» is invalid', $clientUrl));
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function initFromArray(array $auth): self
    {
        return new self(
            $auth['server_endpoint'],
            $auth['client_endpoint'],
        );
    }
}