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

namespace Bitrix24\SDK\Core\Response\DTO;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

readonly class RenewedAuthToken
{
    /**
     * @param non-empty-string $memberId
     * @param non-empty-string $clientEndpoint
     * @param non-empty-string $serverEndpoint
     * @param non-empty-string $domain
     */
    public function __construct(
        public AuthToken         $authToken,
        public string            $memberId,
        public string            $clientEndpoint,
        public string            $serverEndpoint,
        public ApplicationStatus $applicationStatus,
        public string            $domain)
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function initFromArray(array $response): self
    {
        return new self(
            AuthToken::initFromArray($response),
            (string)$response['member_id'],
            (string)$response['client_endpoint'],
            (string)$response['server_endpoint'],
            ApplicationStatus::initFromString((string)$response['status']),
            (string)$response['domain']
        );
    }
}