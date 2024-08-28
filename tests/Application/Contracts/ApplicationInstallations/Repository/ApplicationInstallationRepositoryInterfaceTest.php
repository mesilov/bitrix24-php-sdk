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

namespace Bitrix24\SDK\Tests\Application\Contracts\ApplicationInstallations\Repository;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationInterface;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Exceptions\ApplicationInstallationNotFoundException;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Repository\ApplicationInstallationRepositoryInterface;
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

#[CoversClass(ApplicationInstallationRepositoryInterface::class)]
abstract class ApplicationInstallationRepositoryInterfaceTest extends TestCase
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

    abstract protected function createApplicationInstallationRepositoryImplementation(): ApplicationInstallationRepositoryInterface;

    /**
     * @throws ApplicationInstallationNotFoundException
     */
    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test save method for install start use case')]
    final public function testSave(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $appInstallationRepo->save($installation);

        $this->assertEquals($installation, $appInstallationRepo->getById($installation->getId()));
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getById method for install start use case')]
    final public function testGetByIdHappyPath(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $appInstallationRepo->save($installation);

        $this->assertEquals($installation, $appInstallationRepo->getById($installation->getId()));
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test getById method for install start use case')]
    final public function testGetByIdWithNonExistsEntity(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $this->expectException(ApplicationInstallationNotFoundException::class);
        $appInstallationRepo->getById(Uuid::v7());
    }

    /**
     * @throws ApplicationInstallationNotFoundException
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test delete method')]
    final public function testDeleteWithHappyPath(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        // successfully finish installation flow
        $installation->applicationInstalled();

        // few moments later application uninstalled
        // we receive ON_APPLICATION_UNINSTALL event and mark application installation as uninstalled: status = deleted
        $installation->applicationUninstalled();
        $appInstallationRepo->save($installation);

        // if we want we can delete application installation from repository
        $appInstallationRepo->delete($installation->getId());

        $this->expectException(ApplicationInstallationNotFoundException::class);
        $appInstallationRepo->getById($installation->getId());
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test delete method with unknown id')]
    final public function testDeleteWithUnknownId(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        // try to delete unknown installation
        $this->expectException(ApplicationInstallationNotFoundException::class);
        $appInstallationRepo->delete(Uuid::v7());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test delete method with wrong state')]
    final public function testDeleteWithWrongState(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $appInstallationRepo->save($installation);

        $this->expectException(InvalidArgumentException::class);
        $appInstallationRepo->delete($installation->getId());
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test findByBitrix24AccountId method')]
    final public function testFindByBitrix24AccountId(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $appInstallationRepo->save($installation);

        $this->assertEquals([$installation], $appInstallationRepo->findByBitrix24AccountId($bitrix24AccountUuid));
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test findByBitrix24AccountId method with unknown id')]
    final public function testFindByBitrix24AccountIdWithUnknownId(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $this->assertEquals([], $appInstallationRepo->findByBitrix24AccountId(Uuid::v7()));
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test findByExternalId method')]
    final public function testFindByExternalId(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $externalId = Uuid::v7()->toRfc4122();
        $installation->setExternalId($externalId);
        $appInstallationRepo->save($installation);

        $this->assertEquals([$installation], $appInstallationRepo->findByExternalId($externalId));
    }

    #[Test]
    #[DataProvider('applicationInstallationDataProvider')]
    #[TestDox('test findByExternalId method with unknown id')]
    final public function testFindByExternalIdWithUnknownId(
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
    ): void
    {
        $appInstallationRepo = $this->createApplicationInstallationRepositoryImplementation();

        $externalId = Uuid::v7()->toRfc4122();
        $this->assertEquals([], $appInstallationRepo->findByExternalId($externalId));
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