<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Credentials\OAuthToken;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ApiClient
 *
 * @package Bitrix24\SDK\Core
 */
class ApiClient
{
    /**
     * @var HttpClientInterface
     */
    protected $client;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var Credentials\Credentials
     */
    protected $credentials;

    /**
     * ApiClient constructor.
     *
     * @param Credentials\Credentials $credentials
     * @param HttpClientInterface     $client
     * @param LoggerInterface         $logger
     */
    public function __construct(Credentials\Credentials $credentials, HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->credentials = $credentials;
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @return Credentials\Credentials
     */
    public function getCredentials(): Credentials\Credentials
    {
        return $this->credentials;
    }

    /**
     * @param Credentials\Credentials $credentials
     */
    public function setCredentials(Credentials\Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }

    /**
     * @return OAuthToken
     */
    public function getNewToken(): OAuthToken
    {
        return new OAuthToken('1', '2', 3600);
    }

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getResponse(string $apiMethod, array $parameters = []): ResponseInterface
    {
        $this->logger->debug(
            sprintf('getResponse.start %s', $apiMethod),
            [
                'domainUrl'  => $this->credentials->getDomainUrl(),
                'parameters' => $parameters,
            ]
        );

        $method = 'POST';

        if ($this->credentials->getWebhookUrl() !== null) {
            $url = sprintf('%s/%s/', $this->credentials->getWebhookUrl()->getUrl(), $apiMethod);
        } else {
            // todo domain rename case
            $url = sprintf('%s/%s', $this->credentials->getDomainUrl(), $apiMethod);
        }


        $requestOptions = [
            'json' => $parameters,
        ];

        $response = $this->client->request($method, $url, $requestOptions);

        $this->logger->debug(
            sprintf('getResponse.end %s', $apiMethod),
            [
                'responseInfo' => $response->getInfo(),
            ]
        );

        return $response;
    }
}