# Авторизация с использованием «Входящего вебхука»

## Документация
[Веб-хуки. Быстрый старт](https://dev.1c-bitrix.ru/learning/course/?COURSE_ID=99&LESSON_ID=8581)

## подключение к Битрикс24 с использованием входящих веб-хуков 
1. Создайте вебхук
2. Установите библиотеку
3. Сконфигурируйте ApiClient для использования авторизации через входящий веб-хук

```php
<?php

declare(strict_types=1);
require_once 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('b24-api-client-debug.log', Logger::DEBUG));

$client = HttpClient::create();

$credentials = new \Bitrix24\SDK\Core\Credentials\Credentials(
    new \Bitrix24\SDK\Core\Credentials\WebhookUrl('https://test.bitrix24.ru/rest/7/9kc3tt3kr7qxjt0c/'),
    null,
    null,
    null
);

$apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $client, $log);

$result = $apiClient->getResponse('app.info');
$result = json_decode($result->getContent(), true);
var_dump($result);
```

## подключение к Битрикс24 с использованием OAuth 2.0 

```php
<?php

declare(strict_types=1);
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
    'client id from application settings',
    'client secret from application settings',
    new \Bitrix24\SDK\Core\Credentials\Scope(
        [
            'crm',
        ]
    )
);
$token = new \Bitrix24\SDK\Core\Credentials\AccessToken(
    '50cc9d5… access token',
    '404bc55… refresh token',
    1604179882
);
$domain = 'https:// client portal address  .bitrix24.ru';
$credentials = \Bitrix24\SDK\Core\Credentials\Credentials::createForOAuth($token, $appProfile, $domain);

$apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $traceableClient, $log);
$app = new \Bitrix24\SDK\Services\Main($apiClient, $log);

$log->debug('================================');
$res = $app->call('app.info');
var_dump($res->getResponseData()->getResult()->getResultData());
```