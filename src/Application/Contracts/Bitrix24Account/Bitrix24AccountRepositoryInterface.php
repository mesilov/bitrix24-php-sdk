<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Account;

use Symfony\Component\Uid\Uuid;

interface Bitrix24AccountRepositoryInterface
{
    /**
     * Save account
     *
     * @param Bitrix24AccountInterface $entity
     * @param bool                     $flush
     *
     * @return void
     */
    public function saveAccount(Bitrix24AccountInterface $entity, bool $flush = false): void;

    /**
     * Get by account id
     *
     * @param \Symfony\Component\Uid\Uuid $id
     *
     * @return Bitrix24AccountInterface
     */
    public function getById(Uuid $id): Bitrix24AccountInterface;

    /**
     * Delete account
     *
     * @param Bitrix24AccountInterface $entity
     * @param bool                     $flush
     *
     * @return void
     */
    public function deleteAccount(Bitrix24AccountInterface $entity, bool $flush = false): void;

    /**
     * Find account by member_id
     *
     * @return ?Bitrix24AccountInterface Returns an array of Bitrix24Account objects
     */
    public function findAccountByMemberId(string $memberId): ?Bitrix24AccountInterface;

    /**
     * Get account by member_id
     *
     * @param string $memberId
     *
     * @return Bitrix24AccountInterface
     */
    public function getAccountByMemberId(string $memberId): Bitrix24AccountInterface;

    /**
     * Find account by contact person id - person, who installed application
     *
     * @param \Symfony\Component\Uid\Uuid $contactPersonId
     *
     * @return Bitrix24AccountInterface|null
     */
    public function findAccountByContactPersonId(Uuid $contactPersonId): ?Bitrix24AccountInterface;

    /**
     * Find account by domain url
     *
     * @param string $domainUrl
     *
     * @return Bitrix24AccountInterface|null
     */
    public function findAccountByDomainUrl(string $domainUrl): ?Bitrix24AccountInterface;
}