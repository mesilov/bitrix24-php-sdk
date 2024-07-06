<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts;
use Symfony\Component\Uid\Uuid;

interface Bitrix24AccountRepositoryInterface
{
    /**
     * Get Bitrix24 account by id
     */
    public function getById(Uuid $uuid): Bitrix24Accounts\Entity\Bitrix24AccountInterface;

    /**
     * @param bool $isFlush save entity to storage, commit transaction in oltp database
     */
    public function save(Bitrix24Accounts\Entity\Bitrix24AccountInterface $bitrix24Account, bool $isFlush = false): void;
}