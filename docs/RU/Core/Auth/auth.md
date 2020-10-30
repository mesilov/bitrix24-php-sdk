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
    null
);

$apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $client, $log);

$result = $apiClient->getResponse('app.info');
$result = json_decode($result->getContent(), true);
var_dump($result);
```

