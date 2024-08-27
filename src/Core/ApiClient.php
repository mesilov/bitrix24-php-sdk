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

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Contracts\ApiClientInterface;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use Bitrix24\SDK\Infrastructure\HttpClient\RequestId\RequestIdGeneratorInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiClient implements ApiClientInterface
{
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
     */
    public function __construct(
        protected Credentials                 $credentials,
        protected HttpClientInterface         $client,
        protected RequestIdGeneratorInterface $requestIdGenerator,
        protected LoggerInterface             $logger)
    {
        $this->logger->debug(
            'ApiClient.init',
            [
                'httpClientType' => $this->client::class,
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

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @throws InvalidArgumentException
     * @throws TransportExceptionInterface
     * @throws TransportException
     */
    public function getNewAuthToken(): RenewedAuthToken
    {
        $requestId = $this->requestIdGenerator->getRequestId();
        $this->logger->debug('getNewAuthToken.start', [
            'requestId' => $requestId
        ]);
        if (!$this->getCredentials()->getApplicationProfile() instanceof \Bitrix24\SDK\Core\Credentials\ApplicationProfile) {
            throw new InvalidArgumentException('application profile not set');
        }

        if (!$this->getCredentials()->getAuthToken() instanceof AuthToken) {
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
                    'refresh_token' => $this->getCredentials()->getAuthToken()->getRefreshToken(),
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
            $newAuthToken = RenewedAuthToken::initFromArray($responseData);

            $this->logger->debug('getNewAuthToken.finish', [
                'requestId' => $requestId
            ]);
            return $newAuthToken;
        }

        if ($response->getStatusCode() === StatusCodeInterface::STATUS_BAD_REQUEST) {
            $this->logger->warning('getNewAuthToken.badRequest',[
                'url'=> $url
            ]);
            throw new TransportException(sprintf('getting new access token failure: %s', $responseData['error']));
        }

        throw new TransportException('getting new access token failure with unknown http-status code %s', $response->getStatusCode());
    }

    /**
     * @param array<mixed> $parameters
     *
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
        if ($this->getCredentials()->getWebhookUrl() instanceof WebhookUrl) {
            $url = sprintf('%s/%s/', $this->getCredentials()->getWebhookUrl()->getUrl(), $apiMethod);
        } else {
            $url = sprintf('%s/rest/%s', $this->getCredentials()->getDomainUrl(), $apiMethod);

            if (!$this->getCredentials()->getAuthToken() instanceof AuthToken) {
                throw new InvalidArgumentException('access token in credentials not found ');
            }

            $parameters['auth'] = $this->getCredentials()->getAuthToken()->getAccessToken();
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