<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Services\ServiceBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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
        $log = new Logger('integration-test');
        $log->pushHandler(new StreamHandler(STDOUT, (int)$_ENV['INTEGRATION_TEST_LOG_LEVEL']));
        $log->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor(true, true));
        $log->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());
        $log->debug('==============================================================');

        $core = (new CoreBuilder())
            ->withLogger($log)
            ->withWebhookUrl($_ENV['BITRIX24_WEBHOOK'])
            ->build();
        $batch = new Batch($core, $log);

        return new ServiceBuilder($core, $batch, $log);
    }
}