<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Catalog\Result;

use Bitrix24\SDK\Services\Catalog\Common\Result\AbstractCatalogItem;

/**
 * @property-read int $iblockId
 * @property-read int $iblockTypeId
 * @property-read int $id
 * @property-read string $lid
 * @property-read string $name
 * @property-read int $productIblockId
 * @property-read int $skuPropertyId
 * @property-read bool $subscription
 * @property-read int $vatId
 * @property-read bool $yandexExport
 */
class CatalogItemResult extends AbstractCatalogItem
{
}