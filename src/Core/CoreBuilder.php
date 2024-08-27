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
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Infrastructure\HttpClient\RequestId\DefaultRequestIdGenerator;
use Bitrix24\SDK\Infrastructure\HttpClient\RequestId\RequestIdGeneratorInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CoreBuilder
 *
 * @package Bitrix24\SDK\Core
 */
class CoreBuilder
{
    private ?ApiClientInterface $apiClient = null;

    private HttpClientInterface $httpClient;

    private EventDispatcherInterface $eventDispatcher;

    private LoggerInterface $logger;

    private ?Credentials $credentials = null;

    private readonly ApiLevelErrorHandler $apiLevelErrorHandler;

    private RequestIdGeneratorInterface $requestIdGenerator;

    /**
     * CoreBuilder constructor.
     */
    public function __construct()
    {
        $this->logger = new NullLogger();
        $this->eventDispatcher = new EventDispatcher();
        $this->httpClient = HttpClient::create(
            [
                'http_version' => '2.0',
                'timeout'      => 120,
            ]
        );
        $this->apiLevelErrorHandler = new ApiLevelErrorHandler($this->logger);
        $this->requestIdGenerator = new DefaultRequestIdGenerator();
    }

    public function withRequestIdGenerator(RequestIdGeneratorInterface $requestIdGenerator): void
    {
        $this->requestIdGenerator = $requestIdGenerator;
    }

    /**
     * @return $this
     */
    public function withCredentials(Credentials $credentials): self
    {
        $this->credentials = $credentials;

        return $this;
    }

    public function withApiClient(ApiClientInterface $apiClient): self
    {
        $this->apiClient = $apiClient;

        return $this;
    }

    public function withHttpClient(HttpClientInterface $httpClient):self
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    public function withLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function withEventDispatcher(EventDispatcherInterface $eventDispatcher): self
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function build(): CoreInterface
    {
        if (!$this->credentials instanceof \Bitrix24\SDK\Core\Credentials\Credentials) {
            throw new InvalidArgumentException('you must set credentials before call method build');
        }

        if (!$this->apiClient instanceof \Bitrix24\SDK\Core\Contracts\ApiClientInterface) {
            $this->apiClient = new ApiClient(
                $this->credentials,
                $this->httpClient,
                $this->requestIdGenerator,
                $this->logger
            );
        }

        return new Core(
            $this->apiClient,
            $this->apiLevelErrorHandler,
            $this->eventDispatcher,
            $this->logger
        );
    }
}