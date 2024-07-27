<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Application\Contracts\ApplicationInstallations\Entity;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationInterface;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationStatus;
use Bitrix24\SDK\Application\PortalLicenseFamily;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Carbon\CarbonImmutable;
use DateInterval;
use DateTime;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(ApplicationInstallationInterface::class)]
abstract class ApplicationInstallationInterfaceTest extends TestCase
{
    abstract protected function createApplicationInstallationImplementation(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId,
    ): ApplicationInstallationInterface;

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getId method')]
    final public function testGetId(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($uuid, $installation->getId());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getCreatedAt method')]
    final public function testGetCreatedAt(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($createdAt, $installation->getCreatedAt());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getCreatedAt method')]
    final public function testGetUpdatedAt(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($updatedAt, $installation->getUpdatedAt());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test testGetBitrix24AccountId method')]
    final public function testGetBitrix24AccountId(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($bitrix24AccountUuid, $installation->getBitrix24AccountId());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getContactPersonId method')]
    final public function testGetContactPersonId(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($clientContactPersonUuid, $installation->getContactPersonId());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test changeContactPerson method')]
    final public function testChangeContactPerson(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);

        $newContactPersonId = Uuid::v7();
        $installation->changeContactPerson($newContactPersonId);
        $this->assertEquals($newContactPersonId, $installation->getContactPersonId());
        $this->assertFalse($installation->getCreatedAt()->equalTo($installation->getUpdatedAt()));
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getBitrix24PartnerContactPersonId method')]
    final public function testGetBitrix24PartnerContactPersonId(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($partnerContactPersonUuid, $installation->getBitrix24PartnerContactPersonId());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test changeBitrix24PartnerContactPerson method')]
    final public function testChangeBitrix24PartnerContactPerson(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);

        $newBitrix24PartnerContactPersonId = Uuid::v7();
        $installation->changeBitrix24PartnerContactPerson($newBitrix24PartnerContactPersonId);
        $this->assertEquals($newBitrix24PartnerContactPersonId, $installation->getBitrix24PartnerContactPersonId());
        $this->assertFalse($installation->getCreatedAt()->equalTo($installation->getUpdatedAt()));
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test changeBitrix24Partner method')]
    final public function testChangeBitrix24Partner(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);

        $newBitrix24PartnerUuid = Uuid::v7();
        $installation->changeBitrix24Partner($newBitrix24PartnerUuid);
        $this->assertEquals($newBitrix24PartnerUuid, $installation->getBitrix24PartnerId());
        $this->assertFalse($installation->getCreatedAt()->equalTo($installation->getUpdatedAt()));
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getExternalId method')]
    final public function testGetExternalId(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($externalId, $installation->getExternalId());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test setExternalId method')]
    final public function testSetExternalId(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);

        $newExternalId = Uuid::v7()->toRfc4122();
        $installation->setExternalId($newExternalId);
        $this->assertEquals($newExternalId, $installation->getExternalId());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getStatus method')]
    final public function testGetStatus(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($applicationInstallationStatus, $installation->getStatus());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test applicationInstalled method')]
    final public function testApplicationInstalled(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $installation->applicationInstalled();
        $this->assertEquals(ApplicationInstallationStatus::active, $installation->getStatus());
        $this->assertFalse($installation->getCreatedAt()->equalTo($installation->getUpdatedAt()));

        // try to finish installation in wrong state
        $this->expectException(InvalidArgumentException::class);
        $installation->applicationInstalled();
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test applicationUninstalled method')]
    final public function testApplicationUninstalled(
        Uuid                          $uuid,
        ApplicationInstallationStatus $applicationInstallationStatus,
        CarbonImmutable               $createdAt,
        CarbonImmutable               $updatedAt,
        Uuid                          $bitrix24AccountUuid,
        ApplicationStatus             $applicationStatus,
        PortalLicenseFamily           $portalLicenseFamily,
        ?int                          $portalUsersCount,
        ?Uuid                         $clientContactPersonUuid,
        ?Uuid                         $partnerContactPersonUuid,
        ?Uuid                         $partnerUuid,
        ?string                       $externalId
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $installation->applicationInstalled();
        // a few moments later
        $installation->applicationUninstalled();
        $this->assertEquals(ApplicationInstallationStatus::deleted, $installation->getStatus());
        $this->assertFalse($installation->getCreatedAt()->equalTo($installation->getUpdatedAt()));

        // try to finish installation in wrong state
        $this->expectException(InvalidArgumentException::class);
        $installation->applicationUninstalled();
    }

    public static function applicationInstallationDataProvider(): Generator
    {
        yield 'status-new-all-fields' => [
            Uuid::v7(), // uuid
            ApplicationInstallationStatus::new, // application installation status
            CarbonImmutable::now(), // created at
            CarbonImmutable::createFromMutable((new DateTime())->add(new DateInterval('PT1H'))), // updated at
            Uuid::v7(), // bitrix24 account id
            ApplicationStatus::subscription(), // application status from bitrix24 api call response
            PortalLicenseFamily::nfr, // portal license family value
            42, // bitrix24 portal users count
            Uuid::v7(), // ?client contact person id
            Uuid::v7(), // ?partner contact person id
            Uuid::v7(), // ?partner id
            Uuid::v7()->toRfc4122(), // external id
        ];
        yield 'status-new-without-all-optional-fields' => [
            Uuid::v7(), // uuid
            ApplicationInstallationStatus::new, // application installation status
            CarbonImmutable::now(), // created at
            CarbonImmutable::createFromMutable((new DateTime())->add(new DateInterval('PT1H'))), // updated at
            Uuid::v7(), // bitrix24 account id
            ApplicationStatus::subscription(), // application status from bitrix24 api call response
            PortalLicenseFamily::nfr, // portal license family value
            null, // bitrix24 portal users count
            null, // ?client contact person id
            null, // ?partner contact person id
            null, // ?partner id
            null, // external id
        ];
    }
}