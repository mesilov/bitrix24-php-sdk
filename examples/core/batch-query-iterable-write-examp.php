<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('examples/logs/b24-api-client.log', Logger::DEBUG));
$log->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor(true, true));

try {
    $core = (new \Bitrix24\SDK\Core\CoreBuilder())
        ->withLogger($log)
        // INSERT YOUR WEBHOOK HERE
        ->withWebhookUrl('https://')
        // INSERT YOUR WEBHOOK HERE
        ->build();

    $arraySize = 100;
    print(sprintf('Prepare raw data example...') . PHP_EOL);
    $rawDeals = [];
    for ($i = 0; $i < $arraySize; $i++) {
        $rawDeals[] = [
            'TITLE'       => sprintf('deal-%s', $i),
            'OPPORTUNITY' => 500,
            'CONTACT_ID'  => 76,
        ];
    }
    print(sprintf('deals data count: %s', count($rawDeals)) . PHP_EOL);
    print(sprintf('--------') . PHP_EOL);


    // собираем операции добавления сделок в батч-запросы
    $batch = new \Bitrix24\SDK\Core\Batch($core, $log);
    foreach ($rawDeals as $cnt => $deal) {
        $batch->addCommand('crm.deal.add', $deal);
    }
    print(sprintf('batch commands registered') . PHP_EOL);


    // получаем данные батч-запросов
    print(sprintf('call batch queries and get traversable results for each command...') . PHP_EOL);


    // iterate api-calls result
    $timeStart = microtime(true);
    foreach ($batch->getTraversable(true) as $queryCnt => $queryResultData) {
        /**
         * @var $queryResultData \Bitrix24\SDK\Core\Response\DTO\ResponseData
         */

        print(sprintf(' single query number %s: ', $queryCnt) . PHP_EOL);
        print(sprintf(
                ' time |start: %s |duration %s |',
                $queryResultData->getTime()->getDateStart()->format('H:i:s'),
                $queryResultData->getTime()->getDuration(),
            ) . PHP_EOL);

        print(sprintf(' deal id: %s', $queryResultData->getResult()->getResultData()[0]) . PHP_EOL);

        print(sprintf(' --') . PHP_EOL);
    }
    $timeEnd = microtime(true);
    print(sprintf('batch query duration: %s seconds', round($timeEnd - $timeStart, 2)) . PHP_EOL . PHP_EOL);
} catch (\Throwable $exception) {
    print(sprintf('ошибка: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('тип: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}










