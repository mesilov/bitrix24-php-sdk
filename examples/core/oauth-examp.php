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

$appProfile = new \Bitrix24\SDK\Core\Credentials\ApplicationProfile(
    'local.5f9d4c50b2bf08.70341243',
    'YE56q7neK8SJgP8xqDBlTP2oPYSUf7HUySkob0w9wOWFr1XZCv',
    new \Bitrix24\SDK\Core\Credentials\Scope(
        [
            'crm',
        ]
    )
);
$token = new \Bitrix24\SDK\Core\Credentials\AccessToken(
    '50cc… access token',
    '404b… refresh token',
    0
);
$domain = 'https://domain.bitrix24.ru';
$credentials = \Bitrix24\SDK\Core\Credentials\Credentials::createForOAuth($token, $appProfile, $domain);

try {
    $apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $traceableClient, $log);

    $ed = new \Symfony\Component\EventDispatcher\EventDispatcher();
    $ed->addListener(
        \Bitrix24\SDK\Events\AuthTokenRenewedEvent::class,
        static function (\Bitrix24\SDK\Events\AuthTokenRenewedEvent $event) {
            var_dump('AuthTokenRenewed!');
            print($event->getRenewedToken()->getAccessToken()->getAccessToken() . PHP_EOL);
        }
    );

    $app = (new \Bitrix24\SDK\Core\CoreBuilder())->withCredentials($credentials)->withApiClient($apiClient)->build();

    $log->debug('================================');

    // api call with expired access token
    $res = $app->call('app.info');
    print('result:' . PHP_EOL);

    var_dump($res->getResponseData()->getResult()->getResultData());
    var_dump($res->getResponseData()->getTime()->getDuration());
} catch (\Throwable $exception) {
    print(sprintf('error: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('class: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}