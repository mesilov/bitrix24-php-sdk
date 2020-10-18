<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;

$log = new Logger('b24');
$log->pushHandler(new StreamHandler('b24-api-client-debug.log', Logger::DEBUG));

$client = HttpClient::create();

$credentials = new \Bitrix24\SDK\Core\Credentials\Credentials(
    new \Bitrix24\SDK\Core\Credentials\WebhookUrl('b24 domain'),
    null,
    null
);

$apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $client, $log);

$result = $apiClient->getResponse('crm.deal.get', ['id' => 5]);

var_dump($result->getContent());
