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

namespace Bitrix24\SDK\Services\Workflows\Common;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Endpoints;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;

readonly class Auth
{
    public function __construct(
        public AuthToken         $accessToken,
        public Endpoints         $endpoints,
        public Scope             $scope,
        public ApplicationStatus $applicationStatus,
        public string            $applicationToken,
        public int               $expiresIn,
        public string            $domain,
        public string            $memberId,
        public int               $userId
    )
    {
    }

    /**
     * @throws UnknownScopeCodeException
     * @throws InvalidArgumentException
     */
    public static function initFromArray(array $auth): self
    {
        return new self(
            AuthToken::initFromArray($auth),
            Endpoints::initFromArray($auth),
            Scope::initFromString($auth['scope']),
            ApplicationStatus::initFromString($auth['status']),
            $auth['application_token'],
            (int)$auth['expires_in'],
            $auth['domain'],
            $auth['member_id'],
            (int)$auth['user_id']
        );
    }
}