<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ApplicationInstallations\Entity;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationInterface;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationStatus;
use Bitrix24\SDK\Application\PortalLicenseFamily;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * Class ApplicationInstallationReferenceEntityImplementation
 *
 * This class uses ONLY for demonstration and tests interface, use cases for work with ApplicationInstallationInterface methods
 *
 */
final class ApplicationInstallationReferenceEntityImplementation implements ApplicationInstallationInterface
{
    private ?string $comment;

    public function __construct(
        private readonly Uuid                 $id,
        private ApplicationInstallationStatus $applicationInstallationStatus,
        private readonly CarbonImmutable      $createdAt,
        private CarbonImmutable               $updatedAt,
        private readonly Uuid                 $bitrix24AccountUuid,
        private ApplicationStatus             $applicationStatus,
        private PortalLicenseFamily           $portalLicenseFamily,
        private ?int                          $portalUsersCount,
        private ?Uuid                         $clientContactPersonUuid,
        private ?Uuid                         $partnerContactPersonUuid,
        private ?Uuid                         $bitrix24PartnerUuid,
        private ?string                       $externalId,
    )
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): CarbonImmutable
    {
        return $this->updatedAt;
    }

    public function getStatus(): ApplicationInstallationStatus
    {
        return $this->applicationInstallationStatus;
    }

    public function getBitrix24AccountId(): Uuid
    {
        return $this->bitrix24AccountUuid;
    }

    public function getApplicationStatus(): ApplicationStatus
    {
        return $this->applicationStatus;
    }

    public function getPortalLicenseFamily(): PortalLicenseFamily
    {
        return $this->portalLicenseFamily;
    }

    public function changePortalLicenseFamily(PortalLicenseFamily $portalLicenseFamily): void
    {
        $this->portalLicenseFamily = $portalLicenseFamily;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getPortalUsersCount(): ?int
    {
        return $this->portalUsersCount;
    }

    public function changePortalUsersCount(int $usersCount): void
    {
        $this->portalUsersCount = $usersCount;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getContactPersonId(): ?Uuid
    {
        return $this->clientContactPersonUuid;
    }

    public function changeContactPerson(?Uuid $uuid): void
    {
        $this->clientContactPersonUuid = $uuid;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getBitrix24PartnerContactPersonId(): ?Uuid
    {
        return $this->partnerContactPersonUuid;
    }

    public function changeBitrix24PartnerContactPerson(?Uuid $uuid): void
    {
        $this->partnerContactPersonUuid = $uuid;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getBitrix24PartnerId(): ?Uuid
    {
        return $this->bitrix24PartnerUuid;
    }

    public function changeBitrix24Partner(?Uuid $uuid): void
    {
        $this->bitrix24PartnerUuid = $uuid;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
        $this->updatedAt = new CarbonImmutable();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function applicationInstalled(): void
    {
        if ($this->applicationInstallationStatus !== ApplicationInstallationStatus::new) {
            throw new InvalidArgumentException(sprintf('application installation must be in status «%s», сurrent status «%s»',
                ApplicationInstallationStatus::new->name,
                $this->applicationInstallationStatus->name
            ));
        }
        $this->applicationInstallationStatus = ApplicationInstallationStatus::active;
        $this->updatedAt = new CarbonImmutable();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function applicationUninstalled(): void
    {
        if ($this->applicationInstallationStatus === ApplicationInstallationStatus::new || $this->applicationInstallationStatus === ApplicationInstallationStatus::deleted) {
            throw new InvalidArgumentException(sprintf('application installation must be in status «%s» or «%s», сurrent status «%s»',
                ApplicationInstallationStatus::active->name,
                ApplicationInstallationStatus::blocked->name,
                $this->applicationInstallationStatus->name
            ));
        }
        $this->applicationInstallationStatus = ApplicationInstallationStatus::deleted;
        $this->updatedAt = new CarbonImmutable();
    }

    public function markAsActive(?string $comment): void
    {
        $this->applicationInstallationStatus = ApplicationInstallationStatus::active;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    public function markAsBlocked(?string $comment): void
    {
        $this->applicationInstallationStatus = ApplicationInstallationStatus::blocked;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    public function changeApplicationStatus(ApplicationStatus $applicationStatus): void
    {
        $this->applicationStatus = $applicationStatus;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
