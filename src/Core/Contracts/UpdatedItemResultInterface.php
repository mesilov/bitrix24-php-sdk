<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

interface UpdatedItemResultInterface
{
    /**
     * Success update flag
     */
    public function isSuccess(): bool;
}