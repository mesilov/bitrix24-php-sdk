<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use Money\Currency;
use Money\Money;

/**
 * Class DealProductRowItemResult
 *
 * @property-read int $ID
 * @property-read int $OWNER_ID
 * @property-read string $OWNER_TYPE
 * @property-read int $PRODUCT_ID
 * @property-read string $PRODUCT_NAME
 * @property-read Money $PRICE
 * @property-read Money $PRICE_EXCLUSIVE
 * @property-read Money $PRICE_NETTO
 * @property-read Money $PRICE_BRUTTO
 * @property-read string $QUANTITY
 * @property-read int $DISCOUNT_TYPE_ID
 * @property-read string $DISCOUNT_RATE
 * @property-read string $DISCOUNT_SUM
 * @property-read string $TAX_RATE
 * @property-read string $TAX_INCLUDED
 * @property-read string $CUSTOMIZED
 * @property-read int $MEASURE_CODE
 * @property-read string $MEASURE_NAME
 * @property-read int $RESERVE_ID
 * @property-read int $RESERVE_QUANTITY
 * @property-read int $SORT
 */
class DealProductRowItemResult extends AbstractCrmItem
{

}