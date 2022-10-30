<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts;

use Symfony\Component\Uid\Uuid;

interface Bitrix24AccountRepositoryInterface
{
    /**
     * Сохранение аккаунта
     *
     * @param Bitrix24AccountInterface $entity
     * @param bool            $flush
     *
     * @return void
     */
    public function saveAccount(Bitrix24AccountInterface $entity, bool $flush = false): void;

    /**
     * Получение аккаунта по его идентификатору
     *
     * @param \Symfony\Component\Uid\Uuid $id
     *
     * @return Bitrix24AccountInterface
     */
    public function getById(Uuid $id): Bitrix24AccountInterface;

    /**
     * Физическое удаление аккаунта
     *
     * @param Bitrix24AccountInterface $entity
     * @param bool            $flush
     *
     * @return void
     */
    public function deleteAccount(Bitrix24AccountInterface $entity, bool $flush = false): void;

    /**
     * Поиск аккаунта по member_id
     *
     * @return ?Bitrix24AccountInterface Returns an array of Bitrix24Account objects
     */
    public function findAccountByMemberId(string $memberId): ?Bitrix24AccountInterface;

    /**
     * Получение аккаунта по member_id
     *
     * @param string $memberId
     *
     * @return Bitrix24AccountInterface
     */
    public function getAccountByMemberId(string $memberId): Bitrix24AccountInterface;

    /**
     * Поиск аккаунта по идентификатору контактного лица
     *
     * @param \Symfony\Component\Uid\Uuid $contactPersonId
     *
     * @return Bitrix24AccountInterface|null
     */
    public function findAccountByContactPersonId(Uuid $contactPersonId): ?Bitrix24AccountInterface;

    /**
     * Поиск аккаунта по URL домена
     *
     * @param string $domainUrl
     *
     * @return Bitrix24AccountInterface|null
     */
    public function findAccountByDomainUrl(string $domainUrl): ?Bitrix24AccountInterface;
}