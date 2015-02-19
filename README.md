bitrix24-php-sdk (unofficial)
================
[![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/mesilov/bitrix24-php-sdk?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge) [![License](https://poser.pugx.org/mesilov/bitrix24-php-sdk/license.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk) [![Total Downloads](https://poser.pugx.org/mesilov/bitrix24-php-sdk/downloads.svg)](https://packagist.org/packages/mesilov/bitrix24-php-sdk)

A powerfull PHP library for the Bitrix24 REST API

[Bitrix24 API documentation](http://dev.1c-bitrix.ru/rest_help/)
## Example ##
``` php
// init lib
$obB24App = new \Bitrix24\Bitrix24();
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
## Support ##
email: <mesilov.maxim@gmail.com>  
vk: [mesilov.maxim](https://vk.com/mesilov.maxim)  
twitter: [@mesilov](https://twitter.com/mesilov)
