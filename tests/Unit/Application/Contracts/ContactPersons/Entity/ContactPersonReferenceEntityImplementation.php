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

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Entity;

use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\FullName;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Carbon\CarbonImmutable;
use Darsyn\IP\Version\Multi as IP;
use libphonenumber\PhoneNumber;
use Symfony\Component\Uid\Uuid;

/**
 * This class uses ONLY for demonstration and tests interface, use cases for work with Bitrix24AccountInterface methods
 */
final class ContactPersonReferenceEntityImplementation implements ContactPersonInterface
{
    public function __construct(
        private readonly Uuid            $id,
        private readonly CarbonImmutable $createdAt,
        private CarbonImmutable          $updatedAt,
        private ContactPersonStatus      $contactPersonStatus,
        private string                   $name,
        private ?string                  $surname,
        private ?string                  $patronymic,
        private ?string                  $email,
        private ?CarbonImmutable         $emailVerifiedAt,
        private ?string                  $comment,
        private ?PhoneNumber             $mobilePhone,
        private ?CarbonImmutable         $mobilePhoneVerifiedAt,
        private ?string                  $externalId,
        private readonly ?int            $bitrix24UserId,
        private ?Uuid                    $bitrix24PartnerUuid,
        private readonly ?string         $userAgent,
        private readonly ?string         $userAgentReferer,
        private readonly ?IP             $userAgentIp
    )
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getStatus(): ContactPersonStatus
    {
        return $this->contactPersonStatus;
    }

    public function markAsActive(?string $comment): void
    {
        if (ContactPersonStatus::blocked !== $this->contactPersonStatus) {
            throw new InvalidArgumentException(
                sprintf('you can activate account only in status blocked, now account in status %s',
                    $this->contactPersonStatus->name));
        }

        $this->contactPersonStatus = ContactPersonStatus::active;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    public function markAsDeleted(?string $comment): void
    {
        if (ContactPersonStatus::deleted === $this->contactPersonStatus) {
            throw new InvalidArgumentException(
                sprintf('you cannot mark account as deleted in status %s',
                    $this->contactPersonStatus->name));
        }

        $this->contactPersonStatus = ContactPersonStatus::deleted;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function markAsBlocked(?string $comment): void
    {
        if (ContactPersonStatus::deleted === $this->contactPersonStatus) {
            throw new InvalidArgumentException('you cannot block contact person in status «deleted»');
        }

        $this->contactPersonStatus = ContactPersonStatus::blocked;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getFullName(): FullName
    {
        return new FullName($this->name, $this->surname, $this->patronymic);
    }

    public function changeFullName(FullName $fullName): void
    {
        $this->name = $fullName->name;
        $this->surname = $fullName->surname;
        $this->patronymic = $fullName->patronymic;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): CarbonImmutable
    {
        return $this->updatedAt;
    }

    public function changeEmail(?string $email, ?bool $isEmailVerified = null): void
    {
        $this->emailVerifiedAt = null;
        $this->email = $email;
        if ($isEmailVerified === true) {
            $this->emailVerifiedAt = new CarbonImmutable();
        }

        $this->updatedAt = new CarbonImmutable();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getEmailVerifiedAt(): ?CarbonImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function markEmailAsVerified(): void
    {
        $this->emailVerifiedAt = new CarbonImmutable();
        $this->updatedAt = new CarbonImmutable();
    }

    public function changeMobilePhone(?PhoneNumber $phoneNumber, ?bool $isMobilePhoneVerified = null): void
    {
        $this->mobilePhoneVerifiedAt = null;
        $this->mobilePhone = $phoneNumber;
        if ($isMobilePhoneVerified === true) {
            $this->mobilePhoneVerifiedAt = new CarbonImmutable();
        }

        $this->updatedAt = new CarbonImmutable();
    }

    public function getMobilePhone(): ?PhoneNumber
    {
        return $this->mobilePhone;
    }

    public function getMobilePhoneVerifiedAt(): ?CarbonImmutable
    {
        return $this->mobilePhoneVerifiedAt;
    }

    public function markMobilePhoneAsVerified(): void
    {
        $this->mobilePhoneVerifiedAt = new CarbonImmutable();
        $this->updatedAt = new CarbonImmutable();
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getBitrix24UserId(): ?int
    {
        return $this->bitrix24UserId;
    }

    public function getBitrix24PartnerId(): ?Uuid
    {
        return $this->bitrix24PartnerUuid;
    }

    public function setBitrix24PartnerId(?Uuid $uuid): void
    {
        $this->bitrix24PartnerUuid = $uuid;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function getUserAgentReferer(): ?string
    {
        return $this->userAgentReferer;
    }

    public function getUserAgentIp(): ?IP
    {
        return $this->userAgentIp;
    }
}
