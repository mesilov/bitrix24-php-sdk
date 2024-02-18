<?php

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