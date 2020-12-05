<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('b24-api-client-debug.log', Logger::DEBUG));
$log->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor(true, true));

$client = HttpClient::create(['http_version' => '2.0']);

//$client = new \Symfony\Component\HttpClient\TraceableHttpClient($client);
//$client->setLogger($log);

$credentials = Bitrix24\SDK\Core\Credentials\Credentials::createForWebHook(
    new \Bitrix24\SDK\Core\Credentials\WebhookUrl('')
);

try {
    $apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $client, $log);
    $ed = new \Symfony\Component\EventDispatcher\EventDispatcher();
    $core = new \Bitrix24\SDK\Core\Core($apiClient, $ed, $log);
    $dealsService = new \Bitrix24\SDK\Services\CRM\Deals\Service\Deals($core, $log);


    $firstResult = $dealsService->list([], ['>ID' => 50], ['ID', 'TITLE']);
    $totalCount = $firstResult->getResponseData()->getPagination()->getTotal();


    // примеры формирования батч-запросов на чтение
    // задача: прочитать все сделки из Б24
    // простая стратегия (с подсчётом количества элементов на стороне Б24 на каждом шаге):
    $timeStart = microtime(true);
    $batch = new \Bitrix24\SDK\Core\Batch($core, $log);
    $elementsFromBatchCount = 0;
    foreach ($batch->getTraversableList('crm.deal.list', [], ['>ID' => 50], ['ID', 'TITLE']) as $queryItem) {
        $elementsFromBatchCount++;
        print(sprintf(' %s | %s - %s', $elementsFromBatchCount, $queryItem['ID'], $queryItem['TITLE']) . PHP_EOL);
    }
    $timeEnd = microtime(true);
    print(sprintf('batch query duration: %s seconds', round($timeEnd - $timeStart, 2)) . PHP_EOL . PHP_EOL);
    print(sprintf('elements in bitrix24 count: %s', $totalCount) . PHP_EOL);
    print(sprintf('elements from batch count: %s ', $elementsFromBatchCount) . PHP_EOL . PHP_EOL);


//    // пример вызова списочного метода c получением 50 элементов за один раз
//    print('list method example: ' . PHP_EOL);
//    $result = $dealsService->list(
//        [],
//        ['>ID' => 2],
//        ['ID', 'TITLE'],
//        50
//    );
//    var_dump($result->getResponseData()->getResult()->getResultData());
//    print(sprintf('duration: %s', $result->getResponseData()->getTime()->getDuration()) . PHP_EOL);
//    print(sprintf('total elements: %s', $result->getResponseData()->getPagination()->getTotal()) . PHP_EOL);
//    print(sprintf('next item: %s', $result->getResponseData()->getPagination()->getNextItem()) . PHP_EOL);
//    print('=====' . PHP_EOL);
//
//
//    // https://dev.1c-bitrix.ru/rest_help/rest_sum/start.php
//    print('list method example without elements countable: ' . PHP_EOL);
//    $result = $dealsService->list(
//        [],
//        ['>ID' => 2],
//        ['ID', 'TITLE'],
//        -1
//    );
//    var_dump($result->getResponseData()->getResult()->getResultData());
//    print(sprintf('duration: %s', $result->getResponseData()->getTime()->getDuration()) . PHP_EOL);
//    print(sprintf('total elements: %s', $result->getResponseData()->getPagination()->getTotal()) . PHP_EOL);
//    print(sprintf('next item: %s', $result->getResponseData()->getPagination()->getNextItem()) . PHP_EOL);
//

    // ------------------------------------------------------------------------------
    // пока не делаем, т.к. нет понимания как будет использоваться в клиентском коде
    // стратегия (без подсчёта) (-1)
    // 1. делаем первую выборку
    // 2. проверяем условия достижения окончания (
    // !!!!  при этом необходимо:
    // - отсортировать записи по ID и добавить в фильтр условие ID > значения последнего элемента и с каждым шагом увеличивать его значение.
    // - значение же последнего элемента брать из последнего значения полученного результата.
    // - условием остановки импорта будет пустой ответ, или то, что в ответе элементов меньше 50.
    // продумать кейсы: (выборки элементов), передача \ чтение результатов с автоподстановкой и т.д


} catch (\Throwable $exception) {
    print(sprintf('ошибка: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('тип: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}










