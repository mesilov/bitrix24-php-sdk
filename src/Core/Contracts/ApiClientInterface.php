<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiClientInterface
{
    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
     */
    public function getResponse(string $apiMethod, array $parameters = []): ResponseInterface;

    /**
     * @return RenewedAccessToken
     * @throws InvalidArgumentException
     * @throws TransportExceptionInterface
     */
    public function getNewAccessToken(): RenewedAccessToken;

    /**
     * @return Credentials
     */
    public function getCredentials(): Credentials;
}