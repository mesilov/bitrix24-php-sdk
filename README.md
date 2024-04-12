Bitrix24 REST API PHP SDK
================
[![License](https://poser.pugx.org/mesilov/bitrix24-php-sdk/license.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk) [![Total Downloads](https://poser.pugx.org/mesilov/bitrix24-php-sdk/downloads.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)
[![Latest Stable Version](https://img.shields.io/packagist/v/mesilov/bitrix24-php-sdk.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)

A powerful PHP library for the Bitrix24 REST API

## Build status

| CI\CD [status](https://github.com/mesilov/bitrix24-php-sdk/actions) on `master`                                                                                                                         | 
|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------| 
| [![phpstan check](https://github.com/mesilov/bitrix24-php-sdk/actions/workflows/phpstan.yml/badge.svg)](https://github.com/mesilov/bitrix24-php-sdk/actions/workflows/phpstan.yml)                    | 
| [![unit-tests status](https://github.com/mesilov/bitrix24-php-sdk/actions/workflows/phpunit.yml/badge.svg)](https://github.com/mesilov/bitrix24-php-sdk/actions/workflows/phpunit.yml)                | 
| [![integration-tests status](https://github.com/mesilov/bitrix24-php-sdk/actions/workflows/integration.yml/badge.svg)](https://github.com/mesilov/bitrix24-php-sdk/actions/workflows/integration.yml) | 

Integration tests run in GitHub actions with real Bitrix24 portal 

## BITRIX24-PHP-SDK ✨FEATURES✨

Support both auth modes:

- [x] work with auth tokens for Bitrix24 applications in marketplace
- [x] work with incoming webhooks for simple integration projects for current portal

Domain core events:
  - [x] Access Token expired
  - [x] Bitrix24 portal domain url changed

API - level features

- [x] Auto renew access tokens
- [x] List queries with «start=-1» support
- [ ] offline queues

Performance improvements 🚀

- Batch queries implemented with [PHP Generators](https://www.php.net/manual/en/language.generators.overview.php) – constant low memory and
  low CPI usage
    - [x] batch read data from bitrix24
    - [x] batch write data to bitrix24
    - [ ] write and read in one batch package
    - [ ] composite batch queries to many entities (work in progress)
- [ ] read without count flag

Low-level tools to devs:
- [ ] Rate-limit strategy
- [ ] Retry strategy for safe methods


## Development principles

- Good developer experience
    - auto-completion of methods at the IDE
    - typed method call signatures
    - typed results of method calls
    - helpers for typical operations
- Good documentation
    - documentation on the operation of a specific method containing a link to the official documentation
    - documentation for working with the SDK
- Performance first:
    - minimal impact on client code
    - ability to work with large amounts of data with constant memory consumption
    - efficient operation of the API using batch requests
- Modern technology stack
    - based on [Symfony HttpClient](https://symfony.com/doc/current/http_client.html)
    - actual PHP versions language features
- Reliable:
    - test coverage: unit, integration, contract
    - typical examples typical for different modes of operation and they are optimized for memory \ performance
## Architecture

### Abstraction layers

```
- http2 protocol via json data structures
- symfony http client
- \Bitrix24\SDK\Core\ApiClient - work with b24 rest-api endpoints
    input: arrays \ strings
    output: Symfony\Contracts\HttpClient\ResponseInterface, operate with strings
    process: network operations 
- \Bitrix24\SDK\Services\* - work with b24 rest-api entities
    input: arrays \ strings
    output: b24 response dto
    process: b24 entities, operate with immutable objects  
```
## Sponsors

Help bitrix24-php-sdk by [boosty.to/bitrix24-php-sdk](https://boosty.to/bitrix24-php-sdk)

## Requirements

- php: >=8.2
- ext-json: *
- ext-curl: *

## Installation

Add `"mesilov/bitrix24-php-sdk": "2.x"` to `composer.json` of your application. Or clone repo to your project.

## Examples
### Work with webhook
```php
declare(strict_types=1);

use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once  'vendor/autoload.php';

$webhookUrl = 'INSERT_HERE_YOUR_WEBHOOK_URL';

$log = new Logger('bitrix24-php-sdk');
$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);

// init bitrix24-php-sdk service
$b24Service = $b24ServiceFactory->initFromWebhook($webhookUrl);

// work with interested scope
var_dump($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());
var_dump($b24Service->getCRMScope()->lead()->list([],[],['ID','TITLE'])->getLeads()[0]->TITLE);
```

## Tests

Tests locate in folder `tests` and we have two test types.
In folder tests create file `.env.local` and fill environment variables from `.env`.

### Unit tests

**Fast**, in-memory tests without a network I\O For run unit tests you must call in command line

```shell
composer phpunit-run-unit-test
```

### Integration tests

**Slow** tests with full lifecycle with your **test** Bitrix24 portal via webhook.

❗️Do not run integration tests with production portals

For run integration test you must:

1. Create [new Bitrix24 portal](https://www.bitrix24.ru/create.php?p=255670) for development tests
2. Go to left menu, click «Sitemap»
3. Find menu item «Developer resources»
4. Click on menu item «Other»
5. Click on menu item «Inbound webhook»
6. Assign all permisions with webhook and click «save» button
7. Create file `/tests/.env.local` with same settings, see comments in `/tests/.env` file.

```yaml
APP_ENV=dev
BITRIX24_WEBHOOK=https:// your portal webhook url
INTEGRATION_TEST_LOG_LEVEL=500
```

8. call in command line

```shell
composer composer phpunit-run-integration-tests
```

#### PHP Static Analysis Tool – phpstan

Call in command line

```shell
 composer phpstan-analyse
```

## Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/mesilov/bitrix24-php-sdk/issues)

## License

bitrix24-php-sdk is licensed under the MIT License - see the `MIT-LICENSE.txt` file for details

## Authors

Maksim Mesilov - mesilov.maxim@gmail.com

See also the list of [contributors](https://github.com/mesilov/bitrix24-php-sdk/graphs/contributors) which participated in this project.

## Need custom Bitrix24 application?

mesilov.maxim@gmail.com for private consultations or dedicated support

## Documentation

[Bitrix24 API documentation - Russian](http://dev.1c-bitrix.ru/rest_help/)

[Bitrix24 API documentation - English](https://training.bitrix24.com/rest_help/)

[Register new Bitrix24 account](https://www.bitrix24.ru/create.php?p=255670)