<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Account;

use Symfony\Component\Uid\Uuid;

interface Bitrix24AccountRepositoryInterface
{
    /**
     * Save account
     */
    public function save(Bitrix24AccountInterface $entity, bool $flush = false): void;

    /**
     * Get by account id
     */
    public function getById(Uuid $id): Bitrix24AccountInterface;

    /**
     * Delete account
     */
    public function delete(Bitrix24AccountInterface $entity, bool $flush = false): void;

    /**
     * Find account by member_id
     */
    public function findByMemberId(string $memberId): ?Bitrix24AccountInterface;

    /**
     * Get account by member_id
     */
    public function getByMemberId(string $memberId): Bitrix24AccountInterface;

    /**
     * Find account by contact person id - person, who installed application
     */
    public function findByContactPersonId(Uuid $contactPersonId): ?Bitrix24AccountInterface;

    /**
     * Find account by domain url
     */
    public function findByDomainUrl(string $domainUrl): ?Bitrix24AccountInterface;

    /**
     * @return array<Bitrix24AccountInterface>
     */
    public function findAllActive(): array;

    /**
     * @return array<Bitrix24AccountInterface>
     */
    public function findAllDeactivated(): array;
}