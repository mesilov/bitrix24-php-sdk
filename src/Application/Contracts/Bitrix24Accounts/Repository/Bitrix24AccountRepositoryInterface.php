<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Exceptions\Bitrix24AccountNotFoundException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

interface Bitrix24AccountRepositoryInterface
{
    /**
     * Save bitrix24 account to persistence storage
     */
    public function save(Bitrix24AccountInterface $bitrix24Account): void;

    /**
     * Delete bitrix24 account from
     * @throws Bitrix24AccountNotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(Uuid $uuid): void;

    /**
     * Get bitrix24 account by id
     * @throws Bitrix24AccountNotFoundException
     */
    public function getById(Uuid $uuid): Bitrix24AccountInterface;

    /**
     * Find one admin bitrix24 account by member_id
     * @param non-empty-string $memberId
     * @return Bitrix24AccountInterface|null
     */
    public function findOneAdminByMemberId(string $memberId): ?Bitrix24AccountInterface;

    /**
     * Find bitrix24 accounts by member_id and filter by status and isAdmin flag
     * @param non-empty-string $memberId
     * @return Bitrix24AccountInterface[]
     */
    public function findByMemberId(string $memberId, ?Bitrix24AccountStatus $status = null, ?bool $isAdmin = null): array;

    /**
     * Find bitrix24 accounts by domain url and filter by status adn isAdmin flag
     * @param non-empty-string $domainUrl
     * @return Bitrix24AccountInterface[]
     */
    public function findByDomain(string $domainUrl, ?Bitrix24AccountStatus $status = null, ?bool $isAdmin = null): array;
}