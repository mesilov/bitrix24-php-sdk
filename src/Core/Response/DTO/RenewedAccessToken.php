<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\Scope;

/**
 * Class RenewedAccessToken
 *
 * @package Bitrix24\SDK\Core\Response\DTO
 */
class RenewedAccessToken
{
    private AccessToken $accessToken;
    private string $memberId;
    private string $clientEndpoint;
    private string $serverEndpoint;
    private string $applicationStatus;
    private string $domain;

    /**
     * RenewedAccessToken constructor.
     *
     * @param AccessToken $accessToken
     * @param string      $memberId
     * @param string      $clientEndpoint
     * @param string      $serverEndpoint
     * @param string      $applicationStatus
     * @param string      $domain
     */
    public function __construct(
        AccessToken $accessToken,
        string $memberId,
        string $clientEndpoint,
        string $serverEndpoint,
        string $applicationStatus,
        string $domain
    ) {
        $this->accessToken = $accessToken;
        $this->memberId = $memberId;
        $this->clientEndpoint = $clientEndpoint;
        $this->serverEndpoint = $serverEndpoint;
        $this->applicationStatus = $applicationStatus;
        $this->domain = $domain;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getMemberId(): string
    {
        return $this->memberId;
    }

    /**
     * @return string
     */
    public function getClientEndpoint(): string
    {
        return $this->clientEndpoint;
    }

    /**
     * @return string
     */
    public function getServerEndpoint(): string
    {
        return $this->serverEndpoint;
    }

    /**
     * @return string
     */
    public function getApplicationStatus(): string
    {
        return $this->applicationStatus;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param array $response
     *
     * @return self
     */
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