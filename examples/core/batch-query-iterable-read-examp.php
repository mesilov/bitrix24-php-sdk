<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$log = new Logger('examp');
$log->pushHandler(new StreamHandler('examples/logs/b24-api-client.log', Logger::DEBUG));
$log->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor(true, true));
$log->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());
$log->debug('==============================================================');

try {
    print('получаем данные:' . PHP_EOL);

    $core = (new \Bitrix24\SDK\Core\CoreBuilder())
        ->withLogger($log)
        // INSERT YOUR WEBHOOK HERE
        ->withWebhookUrl('https://')
        // INSERT YOUR WEBHOOK HERE
        ->build();
    $dealsService = new \Bitrix24\SDK\Services\CRM\Deals\Service\Deals($core, $log);

    $select = ['ID', 'TITLE'];
    $firstResult = $dealsService->list([], ['>ID' => 50], $select);
    $totalCount = $firstResult->getResponseData()->getPagination()->getTotal();


    // примеры формирования батч-запросов на чтение
    // задача: прочитать все сделки из Б24
    // простая стратегия (с подсчётом количества элементов на стороне Б24 на каждом шаге):


    $order = ['ID' => 'ASC'];
    $filter = ['>ID' => 1];
    $select = ['ID', 'NAME', 'PHONE', 'EMAIL', 'IM'];

    $timeStart = microtime(true);
    $elementsFromBatchCount = 0;
    $batch = new \Bitrix24\SDK\Core\Batch($core, $log);
    foreach ($batch->getTraversableList('crm.contact.list', $order, $filter, $select, 6000) as $queryItem) {
        $curTime = microtime(true);
        $elementsFromBatchCount++;
        print(sprintf(
                '%s Mb| %s sec |item %s |%s - %s ',
                round(memory_get_peak_usage(true) / 1024 / 1024, 2),
                round($curTime - $timeStart, 2),
                $elementsFromBatchCount,
                $queryItem['ID'],
                $queryItem['NAME']
            ) . PHP_EOL);
    }

    $timeEnd = microtime(true);
    print(sprintf('batch query duration: %s seconds', round($timeEnd - $timeStart, 2)) . PHP_EOL . PHP_EOL);
    print(sprintf('elements in bitrix24 count: %s', $totalCount) . PHP_EOL);
    print(sprintf('elements from batch count: %s ', $elementsFromBatchCount) . PHP_EOL . PHP_EOL);
} catch (\Throwable $exception) {
    print(sprintf('ошибка: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('тип: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}









