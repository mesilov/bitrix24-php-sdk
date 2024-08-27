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

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Carbon\CarbonImmutable;
use libphonenumber\PhoneNumber;
use Symfony\Component\Uid\Uuid;

interface Bitrix24PartnerInterface
{
    /**
     * @return Uuid bitrix24 partner id
     */
    public function getId(): Uuid;

    /**
     * @return CarbonImmutable date and time bitrix24 partner create
     */
    public function getCreatedAt(): CarbonImmutable;

    /**
     * @return CarbonImmutable date and time bitrix24 partner last change
     */
    public function getUpdatedAt(): CarbonImmutable;

    /**
     * Get external id for bitrix24 partner
     *
     * Return external id for bitrix24 partner related entity in crm or erp - company or smart process
     */
    public function getExternalId(): ?string;

    /**
     * Get external id for bitrix24 partner
     *
     * Set external id for application installation related entity in crm or erp - company or smart process
     * @param non-empty-string|null $externalId
     * @throws InvalidArgumentException
     */
    public function setExternalId(?string $externalId): void;

    /**
     * Get application installation status
     *
     * active - active bitrix24 partner
     * deleted - partner was deleted
     * blocked - partner was blocked
     */
    public function getStatus(): Bitrix24PartnerStatus;

    /**
     * Change status to active for blocked bitrix24 partner accounts
     *
     * You can activate accounts only blocked state
     *
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsActive(?string $comment): void;

    /**
     * Change status to blocked for bitrix24 partner account in state active
     *
     * You can block bitrix24 partner account if you need temporally stop work with this partner
     *
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsBlocked(?string $comment): void;

    /**
     * Change status to deleted for bitrix24 partner account, use this for soft delete
     *
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsDeleted(?string $comment): void;

    /**
     * Get comment
     */
    public function getComment(): ?string;

    /**
     * Get partner title
     */
    public function getTitle(): string;

    /**
     * Set partner title
     *
     * @param non-empty-string $title
     * @throws InvalidArgumentException
     */
    public function setTitle(string $title): void;

    /**
     * Get partner site
     */
    public function getSite(): ?string;

    /**
     * Set partner site
     *
     * @param non-empty-string|null $site
     * @throws InvalidArgumentException
     */
    public function setSite(?string $site): void;

    /**
     * Get partner phone
     */
    public function getPhone(): ?PhoneNumber;

    /**
     * Set partner phone
     */
    public function setPhone(?PhoneNumber $phoneNumber): void;

    /**
     * Get partner email
     */
    public function getEmail(): ?string;

    /**
     * Set partner email
     *
     * @param non-empty-string|null $email
     * @throws InvalidArgumentException
     */
    public function setEmail(?string $email): void;

    /**
     * Get bitrix24 partner id
     */
    public function getBitrix24PartnerId(): ?int;

    /**
     * Set bitrix24 partner id
     * @param positive-int|null $bitrix24PartnerId bitrix24 partner id from vendor site
     * @throws InvalidArgumentException
     */
    public function setBitrix24PartnerId(?int $bitrix24PartnerId): void;

    /**
     * Get open line id
     */
    public function getOpenLineId(): ?string;

    /**
     * Set open line id
     * @param non-empty-string|null $openLineId support open line identifier
     * @throws InvalidArgumentException
     */
    public function setOpenLineId(?string $openLineId): void;
}
