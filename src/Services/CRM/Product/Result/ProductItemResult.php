<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Product\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;

/**
 * Class ProductItemResult
 *
 * @property-read int    $ID
 * @property-read int    $CATALOG_ID
 * @property-read string $PRICE
 * @property-read string $CURRENCY_ID
 * @property-read string $NAME
 * @property-read string $CODE
 * @property-read string $DESCRIPTION
 * @property-read string $DESCRIPTION_TYPE
 * @property-read string $ACTIVE
 * @property-read int    $SECTION_ID
 * @property-read int    $SORT
 * @property-read int    $VAT_ID
 * @property-read string $VAT_INCLUDED
 * @property-read int    $MEASURE
 * @property-read string $XML_ID
 * @property-read string $PREVIEW_PICTURE
 * @property-read string $DETAIL_PICTURE
 * @property-read string $DATE_CREATE
 * @property-read string $TIMESTAMP_X
 * @property-read int    $MODIFIED_BY
 * @property-read int    $CREATED_BY
 */
class ProductItemResult extends AbstractCrmItem
{
}