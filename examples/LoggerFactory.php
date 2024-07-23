<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    public static function get(): LoggerInterface
    {
        $log = new Logger('bitrix24-php-sdk');
        $log->pushHandler(new StreamHandler($_ENV['LOGS_FILE_NAME'], (int)$_ENV['LOGS_LEVEL']));
        $log->pushProcessor(new MemoryUsageProcessor(true, true));
        $log->pushProcessor(new IntrospectionProcessor((int)$_ENV['LOGS_LEVEL']));

        return $log;
    }
}