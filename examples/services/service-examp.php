<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Bitrix24\SDK\Services\ServiceBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$log = new Logger('examp');
$log->pushHandler(new StreamHandler('examples/logs/b24-api-client.log', Logger::DEBUG));
$log->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor(true, true));
$log->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());
$log->debug('==============================================================');

try {
    print('получаем данные:' . PHP_EOL);

    // сконфигурировали SDK
    $core = (new \Bitrix24\SDK\Core\CoreBuilder())
        ->withLogger($log)
        // INSERT YOUR WEBHOOK HERE
        ->withWebhookUrl('')
        // INSERT YOUR WEBHOOK HERE
        ->build();
    $batch = new \Bitrix24\SDK\Core\Batch($core, $log);
    $serviceBuilder = new ServiceBuilder($core, $batch, $log);

    // получили сервис по работе с контактами из модуля CRM
    // именно сервис предоставляет CRUD+ api по работе с сущностью
    $contactService = $serviceBuilder->getCRMScope()->contacts();

    // получили первые 50 контактов вызвав метод crm.contact.list
    $contacts = $contactService->list([], [], [], 0);
    var_dump($contacts->getResponseData()->getResult()->getResultData());
    var_dump($contacts->getResponseData()->getPagination()->getTotal());
} catch (\Throwable $exception) {
    print(sprintf('ошибка: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('тип: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}