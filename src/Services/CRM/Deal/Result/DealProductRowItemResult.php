<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;
use Money\Money;
use MoneyPHP\Percentage\Percentage;

use Bitrix24\SDK\Services\CRM\Common\Result\DiscountType;
use Carbon\CarbonImmutable;
use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
/**
 * @property-read int $ID
 * @property-read int $OWNER_ID
 * @property-read string $OWNER_TYPE
 * @property-read int $PRODUCT_ID
 * @property-read string $PRODUCT_NAME
 * @property-read string|null $ORIGINAL_PRODUCT_NAME
 * @property-read string|null $PRODUCT_DESCRIPTION
 * @property-read Money $PRICE price with taxes and discounts
 * @property-read Money $PRICE_EXCLUSIVE  without taxes but with discounts
 * @property-read Money $PRICE_NETTO  without taxes and discounts
 * @property-read Money $PRICE_BRUTTO without discounts but with taxes
 * @property-read Money $PRICE_ACCOUNT formatted price
 * @property-read string $QUANTITY
 * @property-read DiscountType $DISCOUNT_TYPE_ID
 * @property-read Percentage $DISCOUNT_RATE
 * @property-read Money $DISCOUNT_SUM
 * @property-read string $TAX_RATE
 * @property-read bool $TAX_INCLUDED
 * @property-read string $CUSTOMIZED
 * @property-read int $MEASURE_CODE
 * @property-read string $MEASURE_NAME
 * @property-read int $SORT
 * @property-read string|null $XML_ID
 * @property-read int $TYPE
 * @property-read int|null $STORE_ID
 * @property-read int|null $RESERVE_ID
 * @property-read CarbonImmutable|null $DATE_RESERVE_END
 * @property-read int|null $RESERVE_QUANTITY
 */
class DealProductRowItemResult extends AbstractCrmItem
{
}