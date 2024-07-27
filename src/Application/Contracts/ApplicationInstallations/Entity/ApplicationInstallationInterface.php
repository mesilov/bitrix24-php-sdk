<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\PortalLicenseFamily;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;

interface ApplicationInstallationInterface
{
    /**
     * @return Uuid unique application installation id
     */
    public function getId(): Uuid;

    /**
     * @return CarbonImmutable date and time application installation create
     */
    public function getCreatedAt(): CarbonImmutable;

    /**
     * @return CarbonImmutable date and time application installation last change
     */
    public function getUpdatedAt(): CarbonImmutable;

    /**
     * @return Uuid get Bitrix24 Account id related with this installation
     */
    public function getBitrix24AccountId(): Uuid;

    /**
     * @return Uuid|null get contact person id related with this installation, optional
     */
    public function getContactPersonId(): ?Uuid;

    /**
     * Change contact person
     */
    public function changeContactPerson(?Uuid $uuid): void;

    /**
     * @return Uuid|null get bitrix24 partner contact person id related with this installation, optional
     */
    public function getBitrix24PartnerContactPersonId(): ?Uuid;

    /**
     * Change bitrix24 partner contact person
     */
    public function changeBitrix24PartnerContactPerson(?Uuid $uuid): void;

    /**
     * @return Uuid|null get Bitrix24 Partner id related with this installation, optional
     */
    public function getBitrix24PartnerId(): ?Uuid;

    /**
     * Change bitrix24 partner
     */
    public function changeBitrix24Partner(?Uuid $uuid): void;

    /**
     * Get external id for application installation projection in crm / erp - lead or deal id
     * @return string|null application installation projection in crm / erp - lead or deal id
     */
    public function getExternalId(): ?string;

    /**
     * set external id for application installation projection in crm / erp - lead or deal id
     */
    public function setExternalId(?string $externalId): void;

    /**
     * Get application installation status
     *
     * @return ApplicationInstallationStatus
     */
    public function getStatus(): ApplicationInstallationStatus;

    /**
     * Finish application installation
     */
    public function applicationInstalled(): void;

    /**
     * Application uninstalled
     */
    public function applicationUninstalled(): void;

    /**
     * Change status to active
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsActive(?string $comment): void;

    /**
     * Change  status to blocked
     * @param non-empty-string|null $comment
     * @throws InvalidArgumentException
     */
    public function markAsBlocked(?string $comment): void;

    /**
     * Get application status
     */
    public function getApplicationStatus(): ApplicationStatus;

    /**
     * Change application status
     * @link https://training.bitrix24.com/rest_help/general/app_info.php
     */
    public function changeApplicationStatus(ApplicationStatus $applicationStatus): void;

    /**
     * Get plan designation without specified region.
     *
     * @link https://training.bitrix24.com/rest_help/general/app_info.php
     */
    public function getPortalLicenseFamily(): PortalLicenseFamily;

    /**
     * Change plan designation without specified region.
     *
     * @link https://training.bitrix24.com/rest_help/general/app_info.php
     */
    public function changePortalLicenseFamily(PortalLicenseFamily $portalLicenseFamily): void;

    /**
     * Get bitrix24 portal users count
     * @return int|null
     */
    public function getPortalUsersCount(): ?int;

    /**
     * Change bitrix24 portal users count
     *
     * @param int $usersCount
     * @return void
     */
    public function changePortalUsersCount(int $usersCount): void;

    /**
     * Get comment
     */
    public function getComment(): ?string;
}
