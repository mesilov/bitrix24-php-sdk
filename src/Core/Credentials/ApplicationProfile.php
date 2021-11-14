<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

/**
 * Class ApplicationProfile
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class ApplicationProfile
{
    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $clientSecret;
    /**
     * @var Scope
     */
    private $scope;

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
}