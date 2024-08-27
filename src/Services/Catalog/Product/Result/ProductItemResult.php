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

namespace Bitrix24\SDK\Services\Catalog\Product\Result;

use Bitrix24\SDK\Services\Catalog\Common\ProductType;
use Bitrix24\SDK\Services\Catalog\Common\Result\AbstractCatalogItem;
use Carbon\CarbonImmutable;
use Money\Currency;
use Money\Money;

/**
 * @property-read bool $active Active
 * @property-read bool $available Availability, read only
 * @property-read bool $bundle Bundle
 * @property-read ?bool $barcodeMulti
 * @property-read ?bool $canBuyZero Option: Make out-of-stock items available for purchase
 * @property-read string $code Symbolic code
 * @property-read int $createdBy Created by (id)
 * @property-read CarbonImmutable|null $dateActiveFrom Active from
 * @property-read CarbonImmutable|null $dateActiveTo Active till
 * @property-read CarbonImmutable $dateCreate Date created
 * @property-read array|null $detailPicture
 * @property-read string $detailText
 * @property-read string $detailTextType
 * @property-read int $id
 * @property-read int $iblockId
 * @property-read int $iblockSectionId
 * @property-read int $modifiedBy
 * @property-read ?int $height
 * @property-read ?int $length
 * @property-read mixed $measure
 * @property-read string $name
 * @property-read array|null $previewPicture
 * @property-read string $previewText
 * @property-read string $previewTextType
 * @property-read ?Currency $purchasingCurrency
 * @property-read ?Money $purchasingPrice
 * @property-read CarbonImmutable $timestampX
 * @property-read ProductType $type
 * @property-read string $xmlId
 */
class ProductItemResult extends AbstractCatalogItem
{
}