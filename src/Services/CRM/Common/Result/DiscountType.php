<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Common\Result;

enum DiscountType: int
{
    case monetary = 1;
    case percentage = 2;
}