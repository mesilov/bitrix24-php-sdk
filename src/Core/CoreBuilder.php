<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Contracts\ApiClientInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
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
    protected ?ApiClientInterface $apiClient;
    protected HttpClientInterface $httpClient;
    protected EventDispatcherInterface $eventDispatcher;
    protected LoggerInterface $logger;
    protected ?WebhookUrl $webhookUrl;
    protected ?Credentials $credentials;
    protected ApiLevelErrorHandler $apiLevelErrorHandler;

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
        $this->webhookUrl = null;
        $this->credentials = null;
        $this->apiClient = null;
        $this->apiLevelErrorHandler = new ApiLevelErrorHandler($this->logger);
    }

    /**
     * @param Credentials $credentials
     *
     * @return $this
     */
    public function withCredentials(Credentials $credentials): self
    {
        $this->credentials = $credentials;
        return $this;
    }

    /**
     * @param string $webhookUrl
     *
     * @return $this
     */
    public function withWebhookUrl(string $webhookUrl): self
    {
        $this->webhookUrl = new WebhookUrl($webhookUrl);

        return $this;
    }

    /**
     * @param ApiClientInterface $apiClient
     *
     * @return $this
     */
    public function withApiClient(ApiClientInterface $apiClient): self
    {
        $this->apiClient = $apiClient;

        return $this;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function withLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return $this
     */
    public function withEventDispatcher(EventDispatcherInterface $eventDispatcher): self
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @return CoreInterface
     * @throws InvalidArgumentException
     */
    public function build(): CoreInterface
    {
        if ($this->webhookUrl !== null) {
            $this->credentials = Credentials::createForWebHook($this->webhookUrl);
        } elseif ($this->credentials === null) {
            throw new InvalidArgumentException('you must set webhook url or oauth credentials');
        }

        if ($this->apiClient === null) {
            $this->apiClient = new ApiClient(
                $this->credentials,
                $this->httpClient,
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