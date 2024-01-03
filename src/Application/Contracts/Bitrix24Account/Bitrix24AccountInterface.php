<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Account;

use Bitrix24\SDK\Core\Credentials\Scope;
use Symfony\Component\Uid\Uuid;
use Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken;

interface Bitrix24AccountInterface
{
    /**
     * @return Uuid
     */
    public function getId(): Uuid;

    /**
     * @return Uuid
     */
    public function getContactPersonId(): Uuid;

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
     * Get application version
     *
     * @return int
     */
    public function getApplicationVersion(): int;

    /**
     * Update application version if application was updated in marketplace
     *
     * @param int $version
     * @param Scope|null $newScope
     * @return void
     */
    public function updateApplicationVersion(int $version, ?Scope $newScope): void;

    /**
     * Get application scope (permissions)
     *
     * @return Scope
     */
    public function getApplicationScope(): Scope;

    /**
     * @param RenewedAccessToken $renewedAccessToken
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
     * Application installed on portal and finish installation flow
     */
    public function applicationInstalled(string $applicationToken): void;

    /**
     * Application uninstalled from portal
     */
    public function applicationUninstalled(string $applicationToken): void;

    /**
     * Switch account to Active status
     */
    public function markAsActive(): void;

    /**
     * Change account status to Deactivated
     */
    public function markAsDeactivated(): void;

    /**
     * Get Bitrix24 user id who installed application and own this account
     */
    public function getBitrix24UserId(): int;
}