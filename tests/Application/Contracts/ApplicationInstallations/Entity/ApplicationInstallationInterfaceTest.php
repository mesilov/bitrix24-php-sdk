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

    /**
     * @throws InvalidArgumentException
     */
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

        $installation->setExternalId(null);
        $this->assertNull($installation->getExternalId());

        $this->expectException(InvalidArgumentException::class);
        $installation->setExternalId('');
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

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test markAsActive method')]
    final public function testMarkAsActive(
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
        $installation->markAsBlocked('block installation');
        $this->assertEquals(ApplicationInstallationStatus::blocked, $installation->getStatus());

        // a few moments later
        $installation->markAsActive('activate installation');
        $this->assertEquals(ApplicationInstallationStatus::active, $installation->getStatus());


        // try to activate installation in wrong state
        $this->expectException(InvalidArgumentException::class);
        $installation->markAsActive('activate installation in wrong state');
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test markAsBlocked method')]
    final public function testMarkAsBlocked(
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
        $installation->markAsBlocked('block installation');
        $this->assertEquals(ApplicationInstallationStatus::blocked, $installation->getStatus());

        // try to activate installation in wrong state
        $this->expectException(InvalidArgumentException::class);
        $installation->markAsBlocked('activate installation in wrong state');
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getApplicationStatus method')]
    final public function testGetApplicationStatus(
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
        $this->assertEquals($applicationStatus, $installation->getApplicationStatus());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test changeApplicationStatus method')]
    final public function testChangeApplicationStatus(
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
        $this->assertEquals($applicationStatus, $installation->getApplicationStatus());

        $newApplicationStatus = ApplicationStatus::trial();
        $installation->changeApplicationStatus($newApplicationStatus);
        $this->assertEquals($newApplicationStatus, $installation->getApplicationStatus());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getPortalLicenseFamily method')]
    final public function testGetPortalLicenseFamily(
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
        $this->assertEquals($portalLicenseFamily, $installation->getPortalLicenseFamily());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test changePortalLicenseFamily method')]
    final public function testChangePortalLicenseFamily(
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
        $this->assertEquals($portalLicenseFamily, $installation->getPortalLicenseFamily());

        $newLicenseFamily = PortalLicenseFamily::en;
        $installation->changePortalLicenseFamily($newLicenseFamily);
        $this->assertEquals($newLicenseFamily, $installation->getPortalLicenseFamily());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getPortalUsersCount method')]
    final public function testGetPortalUsersCount(
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
        $this->assertEquals($portalUsersCount, $installation->getPortalUsersCount());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test changePortalUsersCount method')]
    final public function testChangePortalUsersCount(
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
        $this->assertEquals($portalUsersCount, $installation->getPortalUsersCount());

        $newUsersCount= 249;
        $installation->changePortalUsersCount($newUsersCount);
        $this->assertEquals($newUsersCount, $installation->getPortalUsersCount());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getComment method')]
    final public function testGetComment(
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
        $comment = 'test block';
        $installation->applicationInstalled();
        $installation->markAsBlocked($comment);
        $this->assertEquals($comment, $installation->getComment());
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