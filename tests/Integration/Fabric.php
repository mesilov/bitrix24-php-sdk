<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Services\ServiceBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class Fabric
 *
 * @package Bitrix24\SDK\Tests\Integration
 */
class Fabric
{
    /**
     * @return ServiceBuilder
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function getServiceBuilder(): ServiceBuilder
    {
        return new ServiceBuilder(self::getCore(), self::getBatchService(), self::getLogger());
    }

    /**
     * @return \Bitrix24\SDK\Core\Contracts\CoreInterface
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function getCore(): CoreInterface
    {
        return (new CoreBuilder())
            ->withLogger(self::getLogger())
            ->withWebhookUrl($_ENV['BITRIX24_WEBHOOK'])
            ->build();
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLogger(): LoggerInterface
    {
        $log = new Logger('integration-test');
        $log->pushHandler(new StreamHandler(STDOUT, (int)$_ENV['INTEGRATION_TEST_LOG_LEVEL']));
        $log->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor(true, true));
        $log->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());

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