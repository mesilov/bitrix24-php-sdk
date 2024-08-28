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

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\BulkItemsReader\BulkItemsReaderBuilder;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ServiceBuilderFactory
{
    private EventDispatcherInterface $eventDispatcher;
    private LoggerInterface $log;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface $log
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $log)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->log = $log;
    }

    /**
     * Init service builder from application account
     *
     * @param ApplicationProfile $applicationProfile
     * @param Bitrix24AccountInterface $bitrix24Account
     *
     * @return ServiceBuilder
     * @throws InvalidArgumentException
     */
    public function initFromAccount(ApplicationProfile $applicationProfile, Bitrix24AccountInterface $bitrix24Account): ServiceBuilder
    {
        return $this->getServiceBuilder(
            Credentials::createFromOAuth(
                $bitrix24Account->getAuthToken(),
                $applicationProfile,
                $bitrix24Account->getDomainUrl()
            )
        );
    }

    /**
     * Init service builder from request
     *
     * @param ApplicationProfile $applicationProfile
     * @param AuthToken $accessToken
     * @param string $bitrix24DomainUrl
     *
     * @return ServiceBuilder
     * @throws InvalidArgumentException
     */
    public function initFromRequest(
        ApplicationProfile $applicationProfile,
        AuthToken          $accessToken,
        string             $bitrix24DomainUrl
    ): ServiceBuilder
    {
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
     * @return ServiceBuilder
     * @throws InvalidArgumentException
     */
    public function initFromWebhook(string $webhookUrl): ServiceBuilder
    {
        return $this->getServiceBuilder(Credentials::createFromWebhook(new WebhookUrl($webhookUrl)));
    }

    /**
     * @param Credentials $credentials
     *
     * @return ServiceBuilder
     * @throws InvalidArgumentException
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