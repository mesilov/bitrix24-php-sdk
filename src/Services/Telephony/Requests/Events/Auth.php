<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string            $access_token
 * @property-read string            $application_token
 * @property-read string            $client_endpoint
 * @property-read string            $domain
 * @property-read int               $expires_in
 * @property-read int               $expires
 * @property-read string            $member_id
 * @property-read Scope             $scope
 * @property-read string            $server_endpoint
 * @property-read ApplicationStatus $status
 * @property-read int               $user_id
 */
class Auth extends AbstractItem
{
    /**
     * @param int|string $offset
     *
     * @return bool|\DateTimeImmutable|int|mixed|null
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function __get($offset)
    {
        return match ($offset) {
            'scope' => Scope::initFromString((string)$this->data[$offset]),
            'status' => ApplicationStatus::initFromString((string)$this->data[$offset]),
            'user_id', 'expires_in', 'expires' => (int)$this->data[$offset],
            default => parent::__get($offset),
        };
    }
}