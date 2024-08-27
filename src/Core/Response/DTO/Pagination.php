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