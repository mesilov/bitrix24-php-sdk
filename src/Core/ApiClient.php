<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
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
     * @const string
     */
    protected const BITRIX24_OAUTH_SERVER_URL = 'https://oauth.bitrix.info';
    /**
     * @const string
     */
    protected const SDK_VERSION = '2.0';

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
     * @return AccessToken
     * @throws InvalidArgumentException
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    public function getNewAccessToken(): AccessToken
    {
        $this->logger->debug(sprintf('getNewAccessToken.start'));
        if ($this->getCredentials()->getApplicationProfile() === null) {
            throw new InvalidArgumentException(sprintf('application profile not set'));
        }
        if ($this->getCredentials()->getAccessToken() === null) {
            throw new InvalidArgumentException(sprintf('access token in credentials not set'));
        }

        $method = 'GET';
        $url = sprintf(
            '%s/oauth/token/?%s',
            $this::BITRIX24_OAUTH_SERVER_URL,
            http_build_query(
                [
                    'grant_type'    => 'refresh_token',
                    'client_id'     => $this->getCredentials()->getApplicationProfile()->getClientId(),
                    'client_secret' => $this->getCredentials()->getApplicationProfile()->getClientSecret(),
                    'refresh_token' => $this->getCredentials()->getAccessToken()->getRefreshToken(),
                ]
            )
        );

        $response = $this->client->request($method, $url, []);
        $result = $response->toArray(true);
        $newAccessToken = AccessToken::initFromArray($result);

        $this->logger->debug(sprintf('getNewAccessToken.finish'));

        return $newAccessToken;
    }

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
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
        if ($this->getCredentials()->getWebhookUrl() !== null) {
            $url = sprintf('%s/%s/', $this->getCredentials()->getWebhookUrl()->getUrl(), $apiMethod);
        } else {
            $url = sprintf('%s/rest/%s', $this->getCredentials()->getDomainUrl(), $apiMethod);

            if ($this->getCredentials()->getAccessToken() === null) {
                throw new InvalidArgumentException(sprintf('access token in credentials not found '));
            }
            $parameters['auth'] = $this->getCredentials()->getAccessToken()->getAccessToken();
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