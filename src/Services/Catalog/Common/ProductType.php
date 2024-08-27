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

namespace Bitrix24\SDK\Services\Catalog\Common;

enum ProductType: int
{
    case simple = 1;
    case bundle = 2;
    case SKU = 3;
    case productOffer = 4;
    case genericOffer = 5;
}