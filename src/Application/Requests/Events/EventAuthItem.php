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

namespace Bitrix24\SDK\Application\Requests\Events;


use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read  non-empty-string $access_token
 * @property-read  int $expires
 * @property-read  int $expires_in
 * @property-read  Scope $scope
 * @property-read  non-empty-string $domain
 * @property-read  non-empty-string $server_endpoint
 * @property-read  non-empty-string $client_endpoint
 * @property-read  non-empty-string $member_id
 * @property-read  ApplicationStatus $status
 * @property-read  int $user_id
 * @property-read  non-empty-string $application_token
 */
class EventAuthItem extends AbstractItem
{
    /**
     * @throws UnknownScopeCodeException
     * @throws InvalidArgumentException
     */
    public function __get($offset)
    {
        return match ($offset) {
            'expires', 'expires_in' => (int)$this->data[$offset],
            'scope' => Scope::initFromString((string)$this->data[$offset]),
            'status' => ApplicationStatus::initFromString((string)$this->data[$offset]),
            default => $this->data[$offset] ?? null,
        };
    }
}