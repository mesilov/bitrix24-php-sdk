Auth with incoming WebHook

## Documentation
[WebHooks](https://training.bitrix24.com/rest_help/rest_sum/webhooks.php)

## use web-hooks 
1. Create WebHook
2. install bitrix24-php-sdk
3. Configure ApiClient for webhook auth

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

