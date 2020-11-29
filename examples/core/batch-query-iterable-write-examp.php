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
//$httpClient = new \Symfony\Component\HttpClient\TraceableHttpClient($client);
//$httpClient->setLogger($log);

// $httpClient = HttpClient::create();


$credentials = Bitrix24\SDK\Core\Credentials\Credentials::createForWebHook(
    new \Bitrix24\SDK\Core\Credentials\WebhookUrl('https://')
);

try {
    $apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $httpClient, $log);
    $ed = new \Symfony\Component\EventDispatcher\EventDispatcher();
    $core = new \Bitrix24\SDK\Core\Core($apiClient, $ed, $log);

    $arraySize = 10000;
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
    // todo режим добавление с чтением


// сравниваем с последовательным добавлением сделок
//    print(sprintf('compare with single query mode...') . PHP_EOL);
//    $dealsService = new \Bitrix24\SDK\Services\CRM\Deals\Service\Deals($core, $log);
//    $timeStart = microtime(true);
//    foreach ($rawDeals as $cnt => $deal) {
//        $dealId = $dealsService->add($deal);
//        print(sprintf('%s | deal id - %s', $cnt, $dealId) . PHP_EOL);
//    }
//    $timeEnd = microtime(true);
//    print(sprintf(' single query mode time: %s', $timeEnd - $timeStart) . PHP_EOL);

} catch (\Throwable $exception) {
    print(sprintf('ошибка: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('тип: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}










