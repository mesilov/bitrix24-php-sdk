bitrix24-php-sdk [![Build Status](https://travis-ci.org/mesilov/bitrix24-php-sdk.svg?branch=master)](https://travis-ci.org/mesilov/bitrix24-php-sdk)
================
[![License](https://poser.pugx.org/mesilov/bitrix24-php-sdk/license.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk) [![Total Downloads](https://poser.pugx.org/mesilov/bitrix24-php-sdk/downloads.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)

A powerfull PHP library for the Bitrix24 REST API

[Bitrix24 API documentation - Russian](http://dev.1c-bitrix.ru/rest_help/)<br />
[Bitrix24 API documentation - English](https://training.bitrix24.com/rest_help/)
## Promo code for new Bitrix24 accounts 
- `b24io5gb` — add 5GB on your Bitrix24
- `b24iousers`  — add 12 users on your Bitrix24  

[Register new Bitrix24 account](https://www.bitrix24.ru/create.php?p=255670)

## Requirements
- php: >=5.3.2
- ext-json: *
- ext-curl: *
- Monolog: optional 

## Example ##
``` php
<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('bitrix24');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::DEBUG));


// init lib
$obB24App = new \Bitrix24\Bitrix24(false, $log);
$obB24App->setApplicationScope($arParams['B24_APPLICATION_SCOPE']);
$obB24App->setApplicationId($arParams['B24_APPLICATION_ID']);
$obB24App->setApplicationSecret($arParams['B24_APPLICATION_SECRET']);
 
// set user-specific settings
$obB24App->setDomain($arParams['DOMAIN']);
$obB24App->setMemberId($arParams['MEMBER_ID']);
$obB24App->setAccessToken($arParams['AUTH_ID']);
$obB24App->setRefreshToken($arParams['REFRESH_ID']);

// get information about current user from bitrix24
$obB24User = new \Bitrix24\User\User($obB24App);
$arCurrentB24User = $obB24User->current();
```
## Installation ##
Add `"mesilov/bitrix24-php-sdk": "dev-master"` to `composer.json` of your application. Or clone repo to your project.

## Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/mesilov/bitrix24-php-sdk/issues)

## License

bitrix24-php-sdk is licensed under the MIT License - see the `MIT-LICENSE.txt` file for details

## Author

Maxim Mesilov - <mesilov.maxim@gmail.com> - <https://twitter.com/mesilov><br />
See also the list of [contributors](https://github.com/mesilov/bitrix24-php-sdk/graphs/contributors) which participated in this project.

## Need custom Bitrix24 application? ##
email: <mesilov.maxim@gmail.com>
