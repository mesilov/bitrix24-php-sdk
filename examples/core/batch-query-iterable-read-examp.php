<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('b24-api-client-debug.log', Logger::DEBUG));

$client = HttpClient::create(['http_version' => '2.0']);
$traceableClient = new \Symfony\Component\HttpClient\TraceableHttpClient($client);
$traceableClient->setLogger($log);

$credentials = Bitrix24\SDK\Core\Credentials\Credentials::createForWebHook(
    new \Bitrix24\SDK\Core\Credentials\WebhookUrl('')
);

try {
    $apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $traceableClient, $log);
    $ed = new \Symfony\Component\EventDispatcher\EventDispatcher();
    $core = new \Bitrix24\SDK\Core\Core($apiClient, $ed, $log);
    $dealsService = new \Bitrix24\SDK\Services\CRM\Deals\Service\Deals($core, $log);


    // пример вызова списочного метода c получением 50 элементов за один раз
    $result = $dealsService->list(
        [],
        ['>ID' => 556],
        ['ID', 'TITLE'],
        50
    );

    var_dump($result->getResponseData()->getResult()->getResultData());
    var_dump($result->getResponseData()->getPagination()->getTotal());
    var_dump($result->getResponseData()->getPagination()->getNextPage());



} catch (\Throwable $exception) {
    print(sprintf('ошибка: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('тип: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}










