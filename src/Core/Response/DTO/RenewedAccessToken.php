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
    private Scope $scope;
    private string $memberId;
    private string $clientEndpoint;
    private string $serverEndpoint;
    private string $applicationStatus;
    private string $domain;

    /**
     * RenewedAccessToken constructor.
     *
     * @param AccessToken $accessToken
     * @param Scope       $scope
     * @param string      $memberId
     * @param string      $clientEndpoint
     * @param string      $serverEndpoint
     * @param string      $applicationStatus
     * @param string      $domain
     */
    public function __construct(
        AccessToken $accessToken,
        Scope $scope,
        string $memberId,
        string $clientEndpoint,
        string $serverEndpoint,
        string $applicationStatus,
        string $domain
    ) {
        $this->accessToken = $accessToken;
        $this->scope = $scope;
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
     * @return Scope
     */
    public function getScope(): Scope
    {
        return $this->scope;
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
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public static function initFromArray(array $response): self
    {
        return new self(
            AccessToken::initFromArray($response),
            new Scope(explode(',', (string)$response['scope'])),
            (string)$response['member_id'],
            (string)$response['client_endpoint'],
            (string)$response['server_endpoint'],
            (string)$response['status'],
            (string)$response['domain']
        );
    }
}

//{
//    "access_token": "s1morf609228iwyjjpvfv6wsvuja4p8u",
//    "refresh_token": "4f9k4jpmg13usmybzuqknt2v9fh0q6rl",
//    "expires_in": 3600,
//    "scope": "app",
//    "member_id": "a223c6b3710f85df22e9377d6c4f7553",
//    "client_endpoint": "https://portal.bitrix24.com/rest/",
//    "server_endpoint": "https://oauth.bitrix.info/rest/",
//    "domain": "oauth.bitrix.info",
//    "status": "T"
//}