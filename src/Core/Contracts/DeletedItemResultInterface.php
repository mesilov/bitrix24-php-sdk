<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

interface DeletedItemResultInterface
{
    /**
     * Success deletion flag
     */
    public function isSuccess(): bool;
}