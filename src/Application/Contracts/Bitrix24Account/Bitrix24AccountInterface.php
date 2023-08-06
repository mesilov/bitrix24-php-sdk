<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Account;

use Symfony\Component\Uid\Uuid;
use Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken;

interface Bitrix24AccountInterface
{
    /**
     * @return \Symfony\Component\Uid\Uuid
     */
    public function getId(): Uuid;
    /**
     * @return \Symfony\Component\Uid\Uuid
     */
    public function getContactPerson(): Uuid;
    /**
     * @return string
     */
    public function getMemberId(): string;
    /**
     * @return string
     */
    public function getDomainUrl(): string;
    /**
     * @return Bitrix24AccountStatus
     */
    public function getStatus(): Bitrix24AccountStatus;
    /**
     * @return string
     */
    public function getAccessToken(): string;
    /**
     * @return string
     */
    public function getRefreshToken(): string;
    /**
     * @return int
     */
    public function getExpires(): int;
    /**
     * @param \Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken $renewedAccessToken
     *
     * @return void
     */
    public function renewAccessToken(RenewedAccessToken $renewedAccessToken): void;
    /**
     * @param string $newDomainUrl
     *
     * @return void
     */
    public function changeDomainUrl(string $newDomainUrl): void;
    /**
     * Switch account to Active status - installation is finalized
     *
     * @param string $applicationToken
     *
     * @return void
     */
    public function markAccountAsActive(string $applicationToken): void;
    /**
     * Change account status to Deleted
     *
     * @param string $applicationToken
     *
     * @return void
     */
    public function markAccountAsDeleted(string $applicationToken): void;
}