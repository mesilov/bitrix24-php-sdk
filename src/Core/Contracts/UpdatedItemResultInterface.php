<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

interface UpdatedItemResultInterface
{
    /**
     * Success update flag
     *
     * @return bool
     */
    public function isSuccess(): bool;
}