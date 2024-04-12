<?php
declare(strict_types=1);

use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once  'vendor/autoload.php';

// load credentials for work with bitrix24 portal
(new Dotenv())->loadEnv('.env');
$webhookUrl = $_ENV['BITRIX24_WEBHOOK_URL'];

// configure logger for debug queries
$log = new Logger('bitrix24-php-sdk');
$log->pushHandler(new StreamHandler($_ENV['LOG_FILE_NAME'], (int)$_ENV['LOG_LEVEL']));
$log->pushProcessor(new MemoryUsageProcessor(true, true));
$log->pushProcessor(new IntrospectionProcessor());

// create factory for build service from multiple sources: webhook, request, bitrix24 account with oauth2.0 tokens
$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
// init bitrix24-php-sdk service with webhook credentials
$b24Service = $b24ServiceFactory->initFromWebhook($webhookUrl);

$deal = $b24Service->getCRMScope()->deal()->get(1)->deal();
var_dump($deal->TITLE);