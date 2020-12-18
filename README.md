bitrix24-php-sdk [![Build Status](https://travis-ci.org/mesilov/bitrix24-php-sdk.svg?branch=master)](https://travis-ci.org/mesilov/bitrix24-php-sdk)
================
[![License](https://poser.pugx.org/mesilov/bitrix24-php-sdk/license.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk) [![Total Downloads](https://poser.pugx.org/mesilov/bitrix24-php-sdk/downloads.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)

A powerful PHP library for the Bitrix24 REST API

[Bitrix24 API documentation - Russian](http://dev.1c-bitrix.ru/rest_help/)<br />
[Bitrix24 API documentation - English](https://training.bitrix24.com/rest_help/)<br />
[Register new Bitrix24 account](https://www.bitrix24.ru/create.php?p=255670)<br />

## SDK 2.0 core features

Bitrix24 auth features

- ~~work with auth tokens~~
- ~~work with incoming webhooks~~

add low-level tools to devs:

- ~~2.1 events (token expired, domain url changed)~~
- 2.2 rate-limiter - wait for symfony/symfony#37471
- 2.3 RetryHttpClient - symfony/symfony#38182

API - level features

- ~~3.1 auto renew access tokens~~
- 3.2 batch queries (work in progress)
- ~~3.2.1 read~~
- ~~3.2.2 write~~
- 3.2.3 read + write
- 3.2.4 read without count flag
- 3.3 list queries with «start=-1» support
- 3.4 offline queues
- 3.5 add change domain URL support

Core DTO

- ~~Response~~
- ~~Scope~~
- ~~Time~~
- ~~OAuthToken~~
- ~~ApplicationProfile~~
- ~~Pagination~~

## SDK Documentation

- [Russian](/docs/RU/documentation.md)
- [English](/docs/EN/documentation.md)

## Architecture

### Abstraction layers

```
- http protocol
- json data
- symfony http client
- \Bitrix24\SDK\Core\ApiClient - work with b24 rest-api endpoints
    input: arrays \ strings
    output: Symfony\Contracts\HttpClient\ResponseInterface, operate with strings
    process: network operations 
- \Bitrix24\SDK\Services\Main - work with b24 rest-api entities
    input: arrays \ strings (?) or queries?
    output: b24 response dto
    process: b24 entities, operate with  
```

### File Structure

```
    /Core
        ApiClient.php - default api-client, work on http abstraction layer, return - Symfony\Contracts\HttpClient\ResponseInterface
    /Services
        /CRM
            /Deals
                /Client
                    Deals.php
                /Exceptions
        /Tasks
        … 
        Main.php - default bitrix24 rest api service provide basic funcions, work with data transfer objects
```

## Requirements

- php: >=7.4
- ext-json: *
- ext-curl: *

## Example ##

## Installation ##

Add `"mesilov/bitrix24-php-sdk": "2.x"` to `composer.json` of your application. Or clone repo to your project.

## Tests ##

SDK test locate in folder `tests` and we have two test types

- Unit: **fast**, in-memory tests without a network I\O
- Integration: **slow** tests with full lifecycle with test Bitrix24 portal via webhook

## Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/mesilov/bitrix24-php-sdk/issues)

## License

bitrix24-php-sdk is licensed under the MIT License - see the `MIT-LICENSE.txt` file for details

## Author

Maxim Mesilov - <mesilov.maxim@gmail.com> - <https://twitter.com/mesilov><br />
See also the list of [contributors](https://github.com/mesilov/bitrix24-php-sdk/graphs/contributors) which participated in this project.

## Need custom Bitrix24 application? ##

email: <mesilov.maxim@gmail.com>

## Русский

### Ключевые особенности

- сервисы возвращают структуры данных пригодные для работы внутри клиентского кода