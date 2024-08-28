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

namespace Bitrix24\SDK\Tests\Integration;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\BulkItemsReader\BulkItemsReaderBuilder;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Events\AuthTokenRenewedEvent;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\ApplicationBridge\ApplicationCredentialsProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Fabric
 *
 * @package Bitrix24\SDK\Tests\Integration
 */
class Fabric
{
    /**
     * @param bool $isNeedApplicationCredentials some rest-api methods need application credentials, incoming webhook doesn't work for call this methods
     * @return ServiceBuilder
     * @throws InvalidArgumentException
     */
    public static function getServiceBuilder(bool $isNeedApplicationCredentials = false): ServiceBuilder
    {
        return new ServiceBuilder(
            self::getCore($isNeedApplicationCredentials),
            self::getBatchService(),
            self::getBulkItemsReader(),
            self::getLogger()
        );
    }

    /**
     * @return string
     */
    public static function getOpenLineCode(): string
    {
        return (string)$_ENV['INTEGRATION_TEST_OPEN_LINE_CODE'];
    }

    /**
     * @return \Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function getBulkItemsReader(): BulkItemsReaderInterface
    {
        return (new BulkItemsReaderBuilder(self::getCore(), self::getBatchService(), self::getLogger()))->build();
    }

    /**
     * @param bool $isNeedApplicationCredentials
     * @return CoreInterface
     * @throws InvalidArgumentException
     */
    public static function getCore(bool $isNeedApplicationCredentials = false): CoreInterface
    {
        $default = (new CoreBuilder())
            ->withLogger(self::getLogger())
            ->withCredentials(
                Credentials::createFromWebhook(
                    new WebhookUrl($_ENV['BITRIX24_PHP_SDK_PLAYGROUND_WEBHOOK'] ?? $_ENV['BITRIX24_WEBHOOK'])
                )
            )
            ->build();

        if ($isNeedApplicationCredentials) {
            // load application credentials and rewrite default incoming webhook credentials from bootstrap.php file
            (new Dotenv())->loadEnv(dirname(__DIR__, 2) . '/tests/ApplicationBridge/.env');

            $credentialsProvider = ApplicationCredentialsProvider::buildProviderForLocalApplication();

            if ($credentialsProvider->isCredentialsAvailable()) {
                // register event handler for store new tokens
                $eventDispatcher = new EventDispatcher();
                $eventDispatcher->addListener(AuthTokenRenewedEvent::class, [
                    $credentialsProvider,
                    'onAuthTokenRenewedEventListener'
                ]);

                $credentials = $credentialsProvider->getCredentials(
                    ApplicationProfile::initFromArray($_ENV),
                    $_ENV['BITRIX24_PHP_SDK_APPLICATION_DOMAIN_URL']);

                return (new CoreBuilder())
                    ->withLogger(self::getLogger())
                    ->withEventDispatcher($eventDispatcher)
                    ->withCredentials($credentials)
                    ->build();
            }
        }
        return $default;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLogger(): LoggerInterface
    {
        $log = new Logger('integration-test');
        $log->pushHandler(new StreamHandler(STDOUT, (int)$_ENV['INTEGRATION_TEST_LOG_LEVEL']));
        $log->pushProcessor(new MemoryUsageProcessor(true, true));
        $log->pushProcessor(new IntrospectionProcessor());

        return $log;
    }

    /**
     * @return \Bitrix24\SDK\Core\Batch
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function getBatchService(): Batch
    {
        return new Batch(self::getCore(), self::getLogger());
    }
}