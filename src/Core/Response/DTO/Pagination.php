<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

readonly class Pagination
{
    public function __construct(
        private ?int $nextItem = null,
        private ?int $total = null)
    {
    }

    public function getNextItem(): ?int
    {
        return $this->nextItem;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }
}