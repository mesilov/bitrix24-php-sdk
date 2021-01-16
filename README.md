bitrix24-php-sdk [![Build Status](https://travis-ci.org/mesilov/bitrix24-php-sdk.svg?branch=master)](https://travis-ci.org/mesilov/bitrix24-php-sdk)
================
[![License](https://poser.pugx.org/mesilov/bitrix24-php-sdk/license.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk) [![Total Downloads](https://poser.pugx.org/mesilov/bitrix24-php-sdk/downloads.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)

A powerful PHP library for the Bitrix24 REST API

[Bitrix24 API documentation - Russian](http://dev.1c-bitrix.ru/rest_help/)<br />
[Bitrix24 API documentation - English](https://training.bitrix24.com/rest_help/)<br />
[Register new Bitrix24 account](https://www.bitrix24.ru/create.php?p=255670)<br />

### SDK 2.0 core features

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

### SDK Documentation

- [Russian](/docs/RU/documentation.md)
- [English](/docs/EN/documentation.md)

### Architecture

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

### Requirements

- php: >=7.4
- ext-json: *
- ext-curl: *

### Example

### Installation

Add `"mesilov/bitrix24-php-sdk": "2.x"` to `composer.json` of your application. Or clone repo to your project.

### Tests

SDK test locate in folder `tests` and we have two test types

- Unit: **fast**, in-memory tests without a network I\O
- Integration: **slow** tests with full lifecycle with test Bitrix24 portal via webhook

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/mesilov/bitrix24-php-sdk/issues)

### License

bitrix24-php-sdk is licensed under the MIT License - see the `MIT-LICENSE.txt` file for details

### Author

Maxim Mesilov - <mesilov.maxim@gmail.com> - <https://twitter.com/mesilov><br />
See also the list of [contributors](https://github.com/mesilov/bitrix24-php-sdk/graphs/contributors) which participated in this project.

### Need custom Bitrix24 application? ##

email: <mesilov.maxim@gmail.com>

### Sponsors

## Русский

### Принципы по которым ведётся разработка

- хороший DX (Developer Experience)
    - автодополнение методов на уровне IDE
    - типизированные сигнатуры вызова методов
    - типизированные результаты вызова методов – используются нативные типы: int, array, bool, string
    - хелперы для типовых операций
- хорошая документация
    - документация по работе конкретного метода содержащая ссылку на офф документацию
    - документация по работе с SDK
- производительность:
    - минимальное влияние на клиентский код
    - возможность работать с большими объёмами данных с константным потреблением памяти
    - эффективная работа c API с использованием батч-запросов
- современный стек технологий:
    - библиотеки для работы с сетью и возможностью асинхронной работы
    - фичи новых версий PHP
- надёжной:
    - покрытие тестами: unit, интеграционные, контрактные
    - есть типовые примеры характерные для разных режимов работы и они оптимизированы по памяти \ быстродействию

### Ключевые особенности

### Слои SDK

### Service – API-интерфейс для работы с конкретной сущностью

Зона ответственности:

- контракт на API-методы сущности

Входящие данные:

- сигнатура вызова конкретного API-метода

Возвращаемый результат:

- `Core\Response` (????) **к обсуждению**

В зависимости от метода может быть разный возвращаемый результат:

- результат выполнения операции типа bool
- идентификатор созданной сущности типа int
- сущность + пользовательские поля с префиксами UF_ типа array
- массив сущностей типа array
- пустой массив как результат пустого фильтра.

Если возвращать `Core\Response`, то в клиентском коде будут проблемы:

- длинные цепочки в клиентском коде для получения возвращаемого результата

```php
// добавили сделку в Б24
$dealId = $dealsService->add($newDeal)->getResponseData()->getResult()->getResultData()[0];
// получили массив сделок
$deals = $dealsService->list([], [], [], 0)->getResponseData()->getResult()->getResultData();
```

- отсутствие релевантной вызываемому методу типизации возвращаемого результата.

Ожидание:

```php
 add(array $newDeal):int // идентификатор новой сделки
 list(array $order, array $filter, array $select, int $start):array //массив сделок + постраничка
 get(int $dealId):array // конкретная сделка
```

Текущая реализация — возвращается унифицированный результат:

```php
add(array $newDeal):Core\Response
list(array $order, array $filter, array $select, int $start):Core\Response
```

#### Core – вызов произвольных API-методов

Зона ответственности:

- вызов **произвольных** API-методов
- обработка ошибок уровня API
- запрос нового токена и повторение запроса, если получили ошибку `expired_token`

Входящие данные:

- `string $apiMethod` – название api-метода
- `array $parameters = []` – аргументы метода

Возвращаемый результат: `Core\Response` – **унифицированный** объект-обёртка, содержит:

- `Symfony\Contracts\HttpClient\ResponseInterface` — объект ответа от сервера, может быть асинхронным
- `Core\Commands\Command` — информация о команде\аргументах которая была исполнена, используется при разборе пакетных запросов.

Для получения результата запроса к API используется метод `Response::getResponseData`, который декодирует тело ответа вызвав
метод `Symfony\Contracts\HttpClient::toArray`
Возвращается стандартизированный DTO `ResponseData` от API-сервера с полями:

- `Result` - DTO c результатом исполнения запроса;
- `Time` — DTO c таймингом прохождения запроса через сервера Битрикс24;
- `Pagination` — DTO постраничной навигации с полями `next` и `total`;

В случае обнаружения ошибок уровня домена будет выброшено соответствующее типизированное исключение.

Объект `Result` содержит метод `getResultData`, который возвращает массив с результатом исполнения API-запроса. В зависимости от вызванного
метода там может быть:

- результат выполнения операции типа bool
- идентификатор созданной сущности типа int
- сущность + пользовательские поля с префиксами UF_ типа array
- массив сущностей типа array
- пустой массив как результат пустого фильтра.

#### ApiClient — работа с сетью и эндпоинтами API-серверов

Зона ответственности:

- передача данных по сети
- соблюдение контракта на эндпоинты с которыми идёт работы
- «подпись» запросов токенами \ передача их в нужные входящие адреса если используется авторизация по вебхукам

Используется:
Symfony HttpClient

Входящие данные:

- тип http-запроса
- массив с параметрами

Возвращаемые результаты:
— `Symfony\Contracts\HttpClient\ResponseInterface`

#### Формат передачи данных по сети

JSON по HTTP/2 или HTTP/1.1

## Спонсоры