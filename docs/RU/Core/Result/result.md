# Типизированные результаты вызова API-методов

Результатом работы API-методов является унифицированный объект `SDK\Core\Response\Response`, но с ним неудобно работать, т.к. он
предоставляет только «общие» методы. В зависимости от типа API-метода сервисы SDK возвращают типизированные результаты.

## Общие принципы

1. Сервисы возвращают типизированные результаты
2. Результаты работы сервиса находятся в одноимённом пространстве имён `Result` который принадлежит сервису сущности.
3. Часть унифицированных результатов вынесена в пространство имён `Core\Result` и используется всеми сервисами, унифицированные результаты
   перечислены ниже:

## Результат добавления сущности — AddItemResult

Является результатом добавления сущности при вызове метода *.add

Содержит метод `getId():int` который позволяет получить идентификатор добавленной сущности.

## Результат удаления сущности — DeletedItemResult

Является результатом удаления сущности при вызове метода *.delete

Содержит метод `isSuccess(): bool` который позволяет понять, была ли успешна операция удаления сущности.

## Результат изменения сущности — UpdatedItemResult

Является результатом изменения сущности при вызове метода *.update

Содержит метод `isSuccess(): bool` который позволяет понять, была ли успешна операция изменения сущности.

## Результат получения описания списка полей — FieldsResult

Является результатом вызова метода с описанием метаданных полей *.fields

Содержит метод `getFieldsDescription(): array` который позволяет получить описание полей для конкретной сущности

## Результат получения сущности — *ItemResult

Является результатом получения сущности или её части, наследуется от `Core\Result\AbstractItem`

Принципы по которым формируются объекты:

1. Результат чтения данных из API - неизменяемый
2. В результате чтения может быть получена как вся сущность, так и её часть.
3. Для системных полей сущности SDK предоставляет автокомплит свойств с помощью phpdoc параметров

Пример описания свойств сделки для объекта `\Bitrix24\SDK\Services\CRM\Deal\Result\DealItemResult`

```php
/**
 * Class DealItemResult
 *
 * @property int         $ID
 * @property string      $TITLE
 * @property string|null $TYPE_ID
 * @property string|null $CATEGORY_ID
 * @property string      $STAGE_ID
 * @property string      $STAGE_SEMANTIC_ID
 * @property string      $IS_NEW
 * @property string      $IS_RECURRING
 * @property string|null $PROBABILITY
 * @property string      $CURRENCY_ID
 * @property string      $OPPORTUNITY
 * @property string      $IS_MANUAL_OPPORTUNITY
 * @property string      $TAX_VALUE
 * @property string      $LEAD_ID
 * @property string      $COMPANY_ID
 * @property string      $CONTACT_ID
 * @property string      $QUOTE_ID
 * @property string      $BEGINDATE
 * @property string      $CLOSEDATE
 * @property string      $OPENED
 * @property string      $CLOSED
 * @property string|null $COMMENTS
 * @property string|null $ADDITIONAL_INFO
 * @property string|null $LOCATION_ID
 * @property string      $IS_RETURN_CUSTOMER
 * @property string      $IS_REPEATED_APPROACH
 * @property int|null    $SOURCE_ID
 * @property string|null $SOURCE_DESCRIPTION
 * @property string|null $ORIGINATOR_ID
 * @property string|null $ORIGIN_ID
 * @property string|null $UTM_SOURCE
 * @property string|null $UTM_MEDIUM
 * @property string|null $UTM_CAMPAIGN
 * @property string|null $UTM_CONTENT
 * @property string|null $UTM_TERM
 */
class DealItemResult extends AbstractItem
{
} 
```