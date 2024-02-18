<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Application\Contracts\Bitrix24Account\Bitrix24AccountInterface;
use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\BulkItemsReader\BulkItemsReaderBuilder;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ServiceBuilderFactory
{
    private EventDispatcherInterface $eventDispatcher;
    private LoggerInterface $log;

    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param \Psr\Log\LoggerInterface                                    $log
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $log)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->log = $log;
    }

    /**
     * Init service builder from application account
     *
     * @param ApplicationProfile       $applicationProfile
     * @param Bitrix24AccountInterface $bitrix24Account
     *
     * @return \Bitrix24\SDK\Services\ServiceBuilder
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function initFromAccount(ApplicationProfile $applicationProfile, Bitrix24AccountInterface $bitrix24Account): ServiceBuilder
    {
        return $this->getServiceBuilder(
            Credentials::createFromOAuth(
                AccessToken::initFromArray(
                    [
                        'access_token'  => $bitrix24Account->getAccessToken(),
                        'refresh_token' => $bitrix24Account->getRefreshToken(),
                        'expires'       => $bitrix24Account->getExpires(),
                    ]
                ),
                $applicationProfile,
                $bitrix24Account->getDomainUrl()
            )
        );
    }

    /**
     * Init service builder from request
     *
     * @param \Bitrix24\SDK\Core\Credentials\ApplicationProfile $applicationProfile
     * @param \Bitrix24\SDK\Core\Credentials\AccessToken        $accessToken
     * @param string                                            $bitrix24DomainUrl
     *
     * @return \Bitrix24\SDK\Services\ServiceBuilder
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function initFromRequest(
        ApplicationProfile $applicationProfile,
        AccessToken $accessToken,
        string $bitrix24DomainUrl
    ): ServiceBuilder {
        return $this->getServiceBuilder(
            Credentials::createFromOAuth(
                $accessToken,
                $applicationProfile,
                $bitrix24DomainUrl
            )
        );
    }

    /**
     * Init service builder from webhook
     *
     * @param string $webhookUrl
     *
     * @return \Bitrix24\SDK\Services\ServiceBuilder
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function initFromWebhook(string $webhookUrl): ServiceBuilder
    {
        return $this->getServiceBuilder(Credentials::createFromWebhook(new WebhookUrl($webhookUrl)));
    }

    /**
     * @param \Bitrix24\SDK\Core\Credentials\Credentials $credentials
     *
     * @return \Bitrix24\SDK\Services\ServiceBuilder
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function getServiceBuilder(Credentials $credentials): ServiceBuilder
    {
        $core = (new CoreBuilder())
            ->withEventDispatcher($this->eventDispatcher)
            ->withLogger($this->log)
            ->withCredentials($credentials)
            ->build();
        $batch = new Batch($core, $this->log);

        return new ServiceBuilder(
            $core,
            $batch,
            (new BulkItemsReaderBuilder(
                $core,
                $batch,
                $this->log
            ))->build(),
            $this->log
        );
    }

}