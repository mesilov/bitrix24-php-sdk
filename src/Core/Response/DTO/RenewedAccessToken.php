<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\Scope;

readonly class RenewedAccessToken
{
    /**
     * RenewedAccessToken constructor.
     */
    public function __construct(
        private AccessToken $accessToken,
        private string      $memberId,
        private string      $clientEndpoint,
        private string      $serverEndpoint,
        private string      $applicationStatus,
        private string      $domain)
    {
    }

    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    public function getMemberId(): string
    {
        return $this->memberId;
    }

    public function getClientEndpoint(): string
    {
        return $this->clientEndpoint;
    }

    public function getServerEndpoint(): string
    {
        return $this->serverEndpoint;
    }

    public function getApplicationStatus(): string
    {
        return $this->applicationStatus;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public static function initFromArray(array $response): self
    {
        return new self(
            AccessToken::initFromArray($response),
            (string)$response['member_id'],
            (string)$response['client_endpoint'],
            (string)$response['server_endpoint'],
            (string)$response['status'],
            (string)$response['domain']
        );
    }
}