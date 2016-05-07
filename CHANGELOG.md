# bitrix24-php-sdk change log
## 0.3.2 (07.05.2016)
* fixed bug in class `Bitrix24\Im\Notify` see issue [ATTACH_ERROR for calls method im.notify for empty attach #42](https://github.com/mesilov/bitrix24-php-sdk/issues/42)
 
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
* add exception class `Bitrix24PortalDeleted` and handle Bitrix24 portal deleted event. See issue [Add support for deleted portals #40](https://github.com/mesilov/bitrix24-php-sdk/issues/40)  

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