<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Contracts\ApiClientInterface;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken;
use Bitrix24\SDK\Infrastructure\HttpClient\RequestId\RequestIdGeneratorInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiClient implements ApiClientInterface
{
    protected HttpClientInterface $client;
    protected LoggerInterface $logger;
    protected Credentials $credentials;
    protected RequestIdGeneratorInterface $requestIdGenerator;
    /**
     * @const string
     */
    protected const BITRIX24_OAUTH_SERVER_URL = 'https://oauth.bitrix.info';
    /**
     * @const string
     */
    protected const SDK_VERSION = '2.0.0';
    protected const SDK_USER_AGENT = 'bitrix24-php-sdk';

    /**
     * ApiClient constructor.
     *
     * @param Credentials $credentials
     * @param HttpClientInterface $client
     * @param RequestIdGeneratorInterface $requestIdGenerator
     * @param LoggerInterface $logger
     */
    public function __construct(
        Credentials                 $credentials,
        HttpClientInterface         $client,
        RequestIdGeneratorInterface $requestIdGenerator,
        LoggerInterface             $logger)
    {
        $this->credentials = $credentials;
        $this->client = $client;
        $this->requestIdGenerator = $requestIdGenerator;
        $this->logger = $logger;
        $this->logger->debug(
            'ApiClient.init',
            [
                'httpClientType' => get_class($client),
            ]
        );
    }

    /**
     * @return array<string,string>
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Accept-Charset' => 'utf-8',
            'User-Agent' => sprintf('%s-v-%s-php-%s', self::SDK_USER_AGENT, self::SDK_VERSION, PHP_VERSION),
            'X-BITRIX24-PHP-SDK-PHP-VERSION' => PHP_VERSION,
            'X-BITRIX24-PHP-SDK-VERSION' => self::SDK_VERSION,
        ];
    }

    /**
     * @return Credentials
     */
    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @return RenewedAccessToken
     * @throws InvalidArgumentException
     * @throws TransportExceptionInterface
     * @throws TransportException
     */
    public function getNewAccessToken(): RenewedAccessToken
    {
        $requestId = $this->requestIdGenerator->getRequestId();
        $this->logger->debug('getNewAccessToken.start', [
            'requestId' => $requestId
        ]);
        if ($this->getCredentials()->getApplicationProfile() === null) {
            throw new InvalidArgumentException('application profile not set');
        }
        if ($this->getCredentials()->getAccessToken() === null) {
            throw new InvalidArgumentException('access token in credentials not set');
        }

        $method = 'GET';
        $url = sprintf(
            '%s/oauth/token/?%s',
            $this::BITRIX24_OAUTH_SERVER_URL,
            http_build_query(
                [
                    'grant_type' => 'refresh_token',
                    'client_id' => $this->getCredentials()->getApplicationProfile()->getClientId(),
                    'client_secret' => $this->getCredentials()->getApplicationProfile()->getClientSecret(),
                    'refresh_token' => $this->getCredentials()->getAccessToken()->getRefreshToken(),
                    $this->requestIdGenerator->getQueryStringParameterName() => $requestId
                ]
            )
        );

        $requestOptions = [
            'headers' => array_merge(
                $this->getDefaultHeaders(),
                [
                    $this->requestIdGenerator->getHeaderFieldName() => $requestId
                ]
            ),
        ];
        $response = $this->client->request($method, $url, $requestOptions);
        $responseData = $response->toArray(false);
        if ($response->getStatusCode() === StatusCodeInterface::STATUS_OK) {
            $newAccessToken = RenewedAccessToken::initFromArray($responseData);

            $this->logger->debug('getNewAccessToken.finish', [
                'requestId' => $requestId
            ]);
            return $newAccessToken;
        }
        if ($response->getStatusCode() === StatusCodeInterface::STATUS_BAD_REQUEST) {
            throw new TransportException(sprintf('getting new access token failure: %s', $responseData['error']));
        }
        throw new TransportException('getting new access token failure with unknown http-status code %s', $response->getStatusCode());
    }

    /**
     * @param string $apiMethod
     * @param array<mixed> $parameters
     *
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
     */
    public function getResponse(string $apiMethod, array $parameters = []): ResponseInterface
    {
        $requestId = $this->requestIdGenerator->getRequestId();
        $this->logger->info(
            'getResponse.start',
            [
                'apiMethod' => $apiMethod,
                'domainUrl' => $this->credentials->getDomainUrl(),
                'parameters' => $parameters,
                'requestId' => $requestId
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
        // duplicate request id in query string for current version of bitrix24 api
        // vendor don't use request id from headers =(
        $url .= '?' . $this->requestIdGenerator->getQueryStringParameterName() . '=' . $requestId;
        $requestOptions = [
            'json' => $parameters,
            'headers' => array_merge(
                $this->getDefaultHeaders(),
                [
                    $this->requestIdGenerator->getHeaderFieldName() => $requestId
                ]
            ),
            // disable redirects, try to catch portal change domain name event
            'max_redirects' => 0,
        ];
        $response = $this->client->request($method, $url, $requestOptions);

        $this->logger->info(
            'getResponse.end',
            [
                'apiMethod' => $apiMethod,
                'responseInfo' => $response->getInfo(),
                'requestId' => $requestId
            ]
        );

        return $response;
    }
}