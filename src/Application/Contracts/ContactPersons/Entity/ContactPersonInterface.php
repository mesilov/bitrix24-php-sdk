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

namespace Bitrix24\SDK\Application\Contracts\ContactPersons\Entity;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Carbon\CarbonImmutable;
use libphonenumber\PhoneNumber;
use Symfony\Component\Uid\Uuid;
use Darsyn\IP\Version\Multi as IP;

interface ContactPersonInterface
{
    /**
     * @return Uuid unique contact person id
     */
    public function getId(): Uuid;

    /**
     * @return ContactPersonStatus  contact person status
     */
    public function getStatus(): ContactPersonStatus;

    /**
     * Set contact person status to active
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsActive(?string $comment): void;

    /**
     * Set contact person status to blocked
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsBlocked(?string $comment): void;

    /**
     * Set contact person status to deleted, use this for soft delete
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsDeleted(?string $comment): void;

    /**
     * @return FullName return contact person full name
     */
    public function getFullName(): FullName;

    public function changeFullName(FullName $fullName): void;

    /**
     * @return CarbonImmutable date and time contact person create
     */
    public function getCreatedAt(): CarbonImmutable;

    /**
     * @return CarbonImmutable date and time contact person change
     */
    public function getUpdatedAt(): CarbonImmutable;

    /**
     * @return string|null get contact person email
     */
    public function getEmail(): ?string;

    public function changeEmail(?string $email, ?bool $isEmailVerified = null): void;

    /**
     * @return void mark contact person email as verified (send check main)
     */
    public function markEmailAsVerified(): void;

    /**
     * @return CarbonImmutable|null is contact person email verified
     */
    public function getEmailVerifiedAt(): ?CarbonImmutable;

    /**
     * Change mobile phone for contact person
     */
    public function changeMobilePhone(?PhoneNumber $phoneNumber, ?bool $isMobilePhoneVerified = null): void;

    public function getMobilePhone(): ?PhoneNumber;

    /**
     * @return CarbonImmutable|null is contact person mobile phone verified
     */
    public function getMobilePhoneVerifiedAt(): ?CarbonImmutable;

    /**
     * @return void mark contact person mobile phone as verified (send check main)
     */
    public function markMobilePhoneAsVerified(): void;

    /**
     * @return non-empty-string|null get comment for this contact person
     */
    public function getComment(): ?string;

    /**
     * set external id for contact person from external system
     */
    public function setExternalId(?string $externalId): void;

    /**
     * get external id for contact person
     */
    public function getExternalId(): ?string;

    /**
     * @return int|null get bitrix24 user id if contact person mapped on bitrix24 user
     */
    public function getBitrix24UserId(): ?int;

    /**
     * @return Uuid|null get bitrix24 partner uuid if contact person is partner employee
     */
    public function getBitrix24PartnerId(): ?Uuid;

    /**
     * @param Uuid|null $uuid set bitrix24 partner uuid if contact person is partner employee
     */
    public function setBitrix24PartnerId(?Uuid $uuid): void;

    /**
     * get user agent for contact person, use for store metadata in consent agreements facts
     */
    public function getUserAgent(): ?string;

    /**
     * get user agent referer for contact person use for store metadata in consent agreements facts
     */
    public function getUserAgentReferer(): ?string;

    /**
     * get user agent ip for contact person use for store metadata in consent agreements facts
     */
    public function getUserAgentIp(): ?IP;
}
