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

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity;

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;

interface Bitrix24AccountInterface
{
    /**
     * @return Uuid unique account id
     */
    public function getId(): Uuid;

    /**
     * @return positive-int Bitrix24 user id who installed application and own this account
     */
    public function getBitrix24UserId(): int;

    /**
     * @return bool Is bitrix24 user has admin rights on portal
     */
    public function isBitrix24UserAdmin(): bool;

    /**
     * @return non-empty-string unique portal id
     */
    public function getMemberId(): string;

    /**
     * @return non-empty-string portal domain url
     */
    public function getDomainUrl(): string;

    /**
     * @return Bitrix24AccountStatus account status
     */
    public function getStatus(): Bitrix24AccountStatus;

    /**
     * @return AuthToken get auth token with access and refresh tokens
     */
    public function getAuthToken(): AuthToken;

    
    public function renewAuthToken(RenewedAuthToken $renewedAuthToken): void;

    /**
     * @return int application version
     */
    public function getApplicationVersion(): int;

    /**
     * @return Scope Get application scope (permissions)
     */
    public function getApplicationScope(): Scope;

    /**
     * @param non-empty-string $newDomainUrl new domain url after portal rename b24-hnst2u.bitrix24.com → acme-inc.bitrix24.com
     */
    public function changeDomainUrl(string $newDomainUrl): void;

    /**
     * @param non-empty-string $applicationToken Application installed on portal and finish installation flow,  set status «active»
     * @throws InvalidArgumentException
     */
    public function applicationInstalled(string $applicationToken): void;

    /**
     * @param string $applicationToken Application uninstalled from portal, set status «deleted»
     * @throws InvalidArgumentException
     */
    public function applicationUninstalled(string $applicationToken): void;

    /**
     * Check is application token valid
     *
     * @param non-empty-string $applicationToken
     * @link https://training.bitrix24.com/rest_help/general/events/event_safe.php
     */
    public function isApplicationTokenValid(string $applicationToken): bool;

    /**
     * @return CarbonImmutable date and time account create
     */
    public function getCreatedAt(): CarbonImmutable;

    /**
     * @return CarbonImmutable date and time account last change
     */
    public function getUpdatedAt(): CarbonImmutable;

    /**
     * Update application version if application was updated in marketplace
     *
     * @param positive-int $version application version from marketplace
     * @param Scope|null $newScope new scope if scope was changed
     * @throws InvalidArgumentException
     */
    public function updateApplicationVersion(int $version, ?Scope $newScope): void;

    /**
     * Change account status to active
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsActive(?string $comment): void;

    /**
     * Change account status to blocked
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsBlocked(?string $comment): void;

    /**
     * @return non-empty-string|null get comment for this account
     */
    public function getComment(): ?string;
}
