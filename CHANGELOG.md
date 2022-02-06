# bitrix24-php-sdk change log

## 2.0-alpha.6 — 7.02.2021

### Added

* add «fast» batch-query without counting elements in result
  recordset [Добавить поддержку выгрузки большого количества данных без подсчёта элементов -1](https://github.com/mesilov/bitrix24-php-sdk/issues/248)
* add `Credentials` in CoreBuilder [set credentials from core builder](https://github.com/mesilov/bitrix24-php-sdk/pull/246)
* add method `Core\Batch::deleteEntityItems` for delete items in batch mode and integration test
* add integration test for read strategy `FilterWithBatchWithoutCountOrderTest`
* add type check in method `Core\Batch::deleteEntityItems` - only integer id allowed
* add interface `Core\Contracts\DeletedItemResultInterface`
* add in scope «CRM» `Services\CRM\Deal\Service\Batch::delete` batch delete deals
* add `symfony/stopwatch` component for integration tests
* add `/Infrastructure/HttpClient/TransportLayer/NetworkTimingsParser` for parse `curl_info` network data structures for debug logs
  in `Bitrix24\SDK\Core\Response::__destruct()`
* add `/Infrastructure/HttpClient/TransportLayer/ResponseInfoParser` for parse `bitrix24_rest_api` timing info for debug logs
  in `Bitrix24\SDK\Core\Response::__destruct()`
* add `Bitrix24\SDK\Core\BulkItemsReader` for data-intensive applications for bulk export data from Bitrix24, read strategies located in
  folder `ReadStrategies`, in services read model **must** use most effective read strategy.
* add integration tests in GitHub Actions pipeline 🎉, now integration tests run on push on `dev-branch`
* add incoming webhook for run integration tests `vendor-check.yml` from vendor CI\CD pipeline

### Changed

* switch `symfony/http-client` to `5.4.*` version requirement.
* switch `symfony/http-client-contracts` to `^2.5` version requirement.
* switch `symfony/event-dispatcher` to `5.4.*` version requirement.
* switch `ramsey/uuid` to `^4.2.3` version requirement.
* switch `psr/log` to `^1.1.4 || ^2.0 || ^3.0` [version requirement](https://github.com/mesilov/bitrix24-php-sdk/issues/245).

## 2.0-alpha.5 – 28.11.2021

### Added

* add method `countByFilter` for all related services, see
  issue [Добавить для всех сущностей метод подсчёта количества элементов по фильтру #228](https://github.com/mesilov/bitrix24-php-sdk/issues/228)
* add in scope «CRM» Userfield service and integration test
* add in scope «CRM» ContactUserfield service and integration test, see
  issue [Добавить сервис по работе с юзерфилдами контакта #231](https://github.com/mesilov/bitrix24-php-sdk/issues/231)
* add method getUserfieldByFieldName for `ContactItemResult`
* add in scope «CRM» DealUserfield service and integration test, see
  issue [Добавить сервис по работе с юзерфилдами cделки #232](https://github.com/mesilov/bitrix24-php-sdk/issues/232)
* add method getUserfieldByFieldName for `DealItemResult`
* add exception `UserfieldNotFoundException`

### Removed

* remove all `0.*` and `1.*` code from `2.*` branch

### Changed

* update type definition for `ContactItemResult`, now return types will be cast to real types: DateTimeInterface, int, boolean etc

## 2.0-alpha.4 – 25.11.2021

### Changed

* switch `symfony/http-client` to `5.3` version requirement.
* switch `symfony/http-client-contracts` to `^2.4` version requirement.
* switch `symfony/event-dispatcher` to `5.3.*` version requirement.
* switch `ramsey/uuid` to `^4.0` version requirement.

### Fixed

* issue [Несовместимость с Laravel 8 #224](https://github.com/mesilov/bitrix24-php-sdk/issues/224)

## 2.0-alpha.3 – 14.11.2021

* add php8 version support
* change in scope «CRM» Product service and integration tests
* add `AddedItemIdResultInterface` for batch-queries result
* add method `countByFilter` for CRM.Contact entity
* fix method name in `ContactsResult`
* add interface `ApiClientInterface`
* bump phpunit version
* bump phpstan version

## 2.0-alpha.2 – 31.01.2021

* remove Travis CI and migrate to Github Actions
* add unit-tests in independent github action
* add phpstan checks in independent github action
* add in scope «CRM» Contacts service and integration test
* add in scope «CRM» Contacts batch service and integration test
* add in scope «CRM» Products service and integration test
* add in scope «CRM» Settings service and integration test
* add in scope «CRM» DealCategoryStage service and integration test
* add in scope «CRM» DealProductRows service and integration test
* add in scope «CRM» DealContact service and integration test
* add in scope «IM» IM service and integration test
* add in default scope «Main» default service

## 2.0-alpha.1 – 11.07.2020

* remove all v1 code
* migrate to Symfony HttpClient
* add documentation webhook auth type
* add OAuth 2.0 support
* add Events support

## 0.1.0 (14.11.2021)

branch version 1.x – bugfix and security releases only

## 0.7.0 (11.07.2020)

* add arguments in method `Bitrix24\Bizproc\Robot::add` for return results support

## 0.6.2 (12.09.2019)

* remove in method, `processBatchCalls` remove call `handleBitrix24APILevelErrors`
* remove php 5.x branch in travis config

## 0.6.1 (20.03.2019)

* add `offset` parameter to entity `CRM\Status\Status` in method `getList`
* add `offset` parameter to entity `User\User` in method `getList`
* add method `messageAdd` to entity `Bitrix24\Bitrix24`
* add method `setEnabledSslVerify` to entity `Classes\Im\Im`
* add entity `Bitrix24\Bizproc\Provider`
* add entity `Bitrix24\CRM\Lead\ProductRows` class to work with products
* fix error in method `crm.company.update`
* fix error in method `Bitrix24::getNewAccessToken`
* fix error in method `Bizproc\Robot::add`
* fix log level in method `Bitrix24::handleBitrix24APILevelErrors`

## 0.6.0 (18.02.2018)

* add support for `FaceTracker` entity
* add presets for request timing information
* add all methods for sonetgroup
* add method `crm.contact.userfield.update`
* add activities methods
* add exception `Bitrix24PortalRenamedException`
* add a pair of fields for the Lead
* add requisite support
* add method update to deal\userfield entity
* add `Product\Property` support
* add method `crm.product.delete`
* add method `crm.product.fields`
* add method `crm.product.property.types`
* add method `crm.product.property.delete`
* add methods for `\Bitrix24\CRM\Status`
* add new placement presets for detail page

## 0.5.4 (8.07.2017)

* add Callback for expired token. Fix pullrequest#63 by valga
* add method `update` in class `Bitrix24\CRM\Product`
* increased curl time out
* add new scope `placement` in class `Bitrix24\Presets\Scope`
* add batch calls method to bitrix24 api client interface

## 0.5.3 (20.05.2017)

* add class `Bitrix24\Placement\Placement`
* add preset `Bitrix24\Presets\Placement\Placement` with placement codes
* add preset `Bitrix24\Presets\Placement\Fields` with placement fields

## 0.5.2 (11.05.2017)

* add preset `Bitrix24\Presets\CRM\Product\ProductRowFields`
* updated preset `Bitrix24\Presets\CRM\Contact\Fields`
* updated preset `Bitrix24\Presets\CRM\Deal\Fields`
* updated preset `Bitrix24\Presets\CRM\Lead\Fields`

## 0.5.1 (30.04.2017)

* add preset `Bitrix24\Presets\CRM\Product\Fields`
* add method `add` in class `Bitrix24\CRM\Product`

## 0.5.0 (4.09.2016)

* add class `Bitrix24\CRM\Quote` see pr [Added support for Quote API calls](https://github.com/mesilov/bitrix24-php-sdk/pull/53/)
* add support http status 301 moved permanently in class `Bitrix24` see
  issue [301 Moved Permanently #49](https://github.com/mesilov/bitrix24-php-sdk/issues/49)
* fixed bug in class `Bitrix24` see pr [Issue in the isAccessTokenExpire method](https://github.com/mesilov/bitrix24-php-sdk/pull/54)

## 0.4.1 (4.08.2016)

* add new events in class `Bitrix24\Presets\Event\Event` see
  issue [Add new bitrix24 events #44](https://github.com/mesilov/bitrix24-php-sdk/issues/44)
* add new scope in class `Bitrix24\Presets\Scope` see
  issue [Update scope presets class #47](https://github.com/mesilov/bitrix24-php-sdk/issues/47)
* remove file with old deprecated exceptions see
  issue [Move all exceptions in namespace «Exceptions» #46](https://github.com/mesilov/bitrix24-php-sdk/issues/46)

## 0.4.0 (16.07.2016)

* remove all exceptions in namespace `\Exceptions` see
  issue [Move all exceptions in namespace «Exceptions» #46](https://github.com/mesilov/bitrix24-php-sdk/issues/46)
* add class `Bitrix24\Exceptions\Bitrix24Exception`
* add class `Bitrix24\Exceptions\Bitrix24IoException`
* add class `Bitrix24\Exceptions\Bitrix24EmptyResponseException`
* add class `Bitrix24\Exceptions\Bitrix24ApiException`
* add class `Bitrix24\Exceptions\Bitrix24WrongClientException`
* add class `Bitrix24\Exceptions\Bitrix24MethodNotFoundException`
* add class `Bitrix24\Exceptions\Bitrix24TokenIsInvalidException`
* add class `Bitrix24\Exceptions\Bitrix24TokenIsExpiredException`
* add class `Bitrix24\Exceptions\Bitrix24PortalDeletedException`
* add class `Bitrix24\Exceptions\Bitrix24PaymentRequiredException`
* add class `Bitrix24\Exceptions\Bitrix24SecurityException`
* updated class `Bitrix24\Bitrix24Exception` mark as **deprecated**
* updated class `Bitrix24\Bitrix24IoException` mark as **deprecated**
* updated class `Bitrix24\Bitrix24EmptyResponseException` mark as **deprecated**
* updated class `Bitrix24\Bitrix24ApiException` mark as **deprecated**
* updated class `Bitrix24\Bitrix24WrongClientException` mark as **deprecated**
* updated class `Bitrix24\Bitrix24MethodNotFoundException` mark as **deprecated**
* updated class `Bitrix24\Bitrix24TokenIsInvalid` mark as **deprecated**
* updated class `Bitrix24\Bitrix24TokenIsExpired` mark as **deprecated**
* updated class `Bitrix24\Bitrix24PortalDeleted` mark as **deprecated**
* updated class `Bitrix24\Bitrix24SecurityException` mark as **deprecated**

## 0.3.4 (06.06.2016)

* add exception class `Bitrix24EmptyResponseException`
* in class `Bitrix24` add debug information for some error types
* temporary remove calls to oauth.bitrix.info for methods `app.info` and `app.stat` see
  issue [Fix errors after change REST API to support self hosted version #43](https://github.com/mesilov/bitrix24-php-sdk/issues/43)

## 0.3.3 (28.05.2016)

* fixed bug in class `Bitrix24` see
  issue [Fix errors after change REST API to support self hosted version #43](https://github.com/mesilov/bitrix24-php-sdk/issues/43)

## 0.3.2 (07.05.2016)

* fixed bug in class `Bitrix24\Im\Notify` see
  issue [ATTACH_ERROR for calls method im.notify for empty attach #42](https://github.com/mesilov/bitrix24-php-sdk/issues/42)

## 0.3.1 (04.05.2016)

* add `dev` branch in GitHub repo
* fixed bug in class `Bitrix24\Im\Attach\Attach`, method `Attach::getAttachItems()` already return array

## 0.3.0 (04.05.2016)

* add class `Bitrix24\Im\Attach\Item\Message` class implements work with string messages in attach item
* add interface `Bitrix24\Presets\Im\iChatColor` with chat color presets
* add phpUnit tests for items:
    * `Bitrix24\Im\Attach\Item\Delimiter`
    * `Bitrix24\Im\Attach\Item\File`
    * `Bitrix24\Im\Attach\Item\Grid`
    * `Bitrix24\Im\Attach\Item\Image`
    * `Bitrix24\Im\Attach\Item\Link`
    * `Bitrix24\Im\Attach\Item\Message`
    * `Bitrix24\Im\Attach\Item\User`
* fixed bug in class `Bitrix24\Im\Attach\Attach`

## 0.2.1 (27.04.2016)

* add exception class `Bitrix24PortalDeleted` and handle Bitrix24 portal deleted event. See
  issue [Add support for deleted portals #40](https://github.com/mesilov/bitrix24-php-sdk/issues/40)

## 0.2.0 (24.06.2015)

* add class `Deal`
* add class `LiveFeedMessage`
* add task fields presets
* add `Bitrix24\CRM\Lead` entity
* add some event fields in presets
* add `Bitrix24\CRM\Contact` entity
* add class `Bitrix24\Task\ChecklistItem`
* add class `Bitrix24\Task\CommentItem`
* add class `Bitrix24\Task\ElapsedItem`
* add class `Bitrix24\Task\Item`
* add class `Bitrix24\Task\Items`
* changed PHP version for Composer
* fixed bug in `Bitrix24\Presets\CRM\Lead`
* fixed bug in class `Invoice`
* remove class `Bitrix24\Task\TaskItems`
* remove class `Bitrix24\Task\TaskItem`

## 0.1.4 (18.04.2015)

* add presets for user fields data type structure
* add method `Update` and predefined constants in class `Invoice`
* add protected method `handleBitrix24APILevelErrors` in a base class
* add some presets for main entity
* add presets for entity `Lead`
* add method get in class `Lead`
* add class `IM`
* add methods get and delete for invoice entity
* add presets for class `Contact`
* add entity events
* add class `Invoice` in namespace `Bitrix24\CRM`
* fixed bug in Fix method isAccessTokenExpire

## 0.1.3 (24.08.2014)

* add const `TOTAL` and `RESULT` for class `Bitrix24\Presets\Main`
* add class `Bitrix24\Presets\Users\Fields` for Bitrix24 users fields
* add class `Bitrix24\Departments\Department`
* add class `Bitrix24\Presets\Events` for Bitrix24 event codes
* add class `Bitrix24\Presets\Uri` for Bitrix24 uri constants
* add class `Bitrix24\Presets\Scope` for Bitrix24 scope constants
* add class `Bitrix24\Application`
* add class `Lead`
* add class `Events`
* add class `Contacts`
* add a composer support
* fixed bug in main class, remove require_once instructions
* fixed bug in __construct in abstract class `Bitrix24Entity`

## 0.1.2 (22.01.2014)

* add security sign support in api-call
* add class `User`
* add method «admin» — Check is current user admin
* add methods `getRedirectUri` and `setRedirectUri`, redirect uri arg support in method `getNewAccessToken`
* add a class `TaskItem`
* add MIT-LICENSE

## 0.1.1 (9.10.2013)

* add namespace support
* add classes of Bitrix24 parts: tasks, sonet
* add base class `Bitrix24Entity`

## 0.1.0 (26.10.2013)

* Initial release