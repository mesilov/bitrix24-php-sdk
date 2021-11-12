<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

interface AddedItemIdResultInterface
{
    /**
     * added entity id
     *
     * @return int
     */
    public function getId(): int;
}