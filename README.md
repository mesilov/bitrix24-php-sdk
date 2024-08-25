Bitrix24 REST API PHP SDK
================
[![License](https://poser.pugx.org/mesilov/bitrix24-php-sdk/license.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk) [![Total Downloads](https://poser.pugx.org/mesilov/bitrix24-php-sdk/downloads.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)
[![Latest Stable Version](https://img.shields.io/packagist/v/mesilov/bitrix24-php-sdk.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)

A powerful PHP library for the Bitrix24 REST API

## Build status

| CI\CD [status](https://github.com/mesilov/bitrix24-php-sdk/actions) on `master`                                                                                                                       | 
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

- [x] Batch queries implemented with [PHP Generators](https://www.php.net/manual/en/language.generators.overview.php) – constant low memory and low CPI usage:
- [x] batch read data from bitrix24
- [x] batch write data to bitrix24
- [x] read without count flag

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
## Documentation

- [Bitrix24 API documentation - English](https://training.bitrix24.com/rest_help/)
- [Internal documentation](docs/EN/documentation.md) for bitrix24-php-sdk

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
1. Go to `/examples/webhook` folder
2. Open console and install dependencies
```shell
composer install
```
3. Open example file and insert webhook url into `$webhookUrl`
```php
declare(strict_types=1);

use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\MemoryUsageProcessor;

require_once 'vendor/autoload.php';

$webhookUrl = 'INSERT_HERE_YOUR_WEBHOOK_URL';

$log = new Logger('bitrix24-php-sdk');
$log->pushHandler(new StreamHandler('bitrix24-php-sdk.log'));
$log->pushProcessor(new MemoryUsageProcessor(true, true));

// create service builder factory
$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
// init bitrix24-php-sdk service from webhook
$b24Service = $b24ServiceFactory->initFromWebhook($webhookUrl);

// work with interested scope
var_dump($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());
// get deals list and address to first element
var_dump($b24Service->getCRMScope()->lead()->list([], [], ['ID', 'TITLE'])->getLeads()[0]->TITLE);
```
4. call php file in cli
```shell
php -f example.php

```

### Create application for Bitrix24 marketplace

if you want to create application you can use production-ready contracts in namespace
`Bitrix24\SDK\Application\Contracts`:

- `Bitrix24Accounts` — Store auth tokens and
  provides [methods](src/Application/Contracts/Bitrix24Accounts/Docs/Bitrix24Accounts.md) for work with Bitrix24
  account.
- `ApplicationInstallations` — Store information about [application installation](src/Application/Contracts/ApplicationInstallations/Docs/ApplicationInstallations.md), linked with Bitrix24 Account with auth
  tokens. Optional can store links to:
    - Client contact person: client person who responsible for application usage
    - Bitrix24 Partner contact person: partner contact person who supports client and configure application
    - Bitrix24 Partner: partner who supports client portal
- `ContactPersons` – Store information [about person](src/Application/Contracts/ContactPersons/Docs/ContactPersons.md) who installed application.
- `Bitrix24Partners` – Store information about [Bitrix24 Partner](src/Application/Contracts/Bitrix24Partners/Docs/Bitrix24Partners.md) who supports client portal and install or configure application. 

Steps:
1. Create own entity of this bounded contexts. 
2. Implement all methods in contract interfaces.
3. Test own implementation behavior with contract-tests `tests/Unit/Application/Contracts/*` – examples.

## Tests

Tests locate in folder `tests` and we have two test types.
In folder tests create file `.env.local` and fill environment variables from `.env`.

### PHP Static Analysis Tool – phpstan

Call in command line

```shell
make lint-phpstan
```
### PHP Static Analysis Tool – rector

Call in command line for validate

```shell
make lint-rector
```
Call in command line for fix codebase

```shell
make lint-rector-fix
```

### Unit tests

**Fast**, in-memory tests without a network I\O For run unit tests you must call in command line

```shell
make test-unit
```

### Integration tests

**Slow** tests with full lifecycle with your **test** Bitrix24 portal via webhook.

❗️Do not run integration tests with production portals

For run integration test you must:

1. Create new Bitrix24 portal for development tests.
2. Go to left menu, click «Sitemap».
3. Find menu item «Developer resources».
4. Click on menu item «Other».
5. Click on menu item «Inbound webhook».
6. Assign all permisions with webhook and click «save» button.
7. Create file `/tests/.env.local` with same settings, see comments in `/tests/.env` file.

```yaml
APP_ENV=dev
BITRIX24_WEBHOOK=https:// your portal webhook url
INTEGRATION_TEST_LOG_LEVEL=500
```

8. call in command line

```shell
make test-integration-core
make test-integration-scope-telephony
make test-integration-scope-workflows
make test-integration-scope-user
```

## Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/mesilov/bitrix24-php-sdk/issues)

## License

bitrix24-php-sdk is licensed under the MIT License - see the `MIT-LICENSE.txt` file for details

## Authors

Maksim Mesilov - mesilov.maxim@gmail.com

See also the list of [contributors](https://github.com/mesilov/bitrix24-php-sdk/graphs/contributors) which participated
in this project.

## Need custom Bitrix24 application?

Email to mesilov.maxim@gmail.com for private consultations or dedicated support.