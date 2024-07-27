<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Application\Contracts\ApplicationInstallations\Entity;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationInterface;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationStatus;
use Bitrix24\SDK\Application\PortalLicenseFamily;
use Carbon\CarbonImmutable;
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
        ?string                       $externalId,
    ): void
    {
        $installation = $this->createApplicationInstallationImplementation($uuid, $applicationInstallationStatus, $createdAt, $updatedAt, $bitrix24AccountUuid, $applicationStatus, $portalLicenseFamily, $portalUsersCount, $clientContactPersonUuid, $partnerContactPersonUuid, $partnerUuid, $externalId);
        $this->assertEquals($uuid, $installation->getId());
    }

    public static function applicationInstallationDataProvider(): Generator
    {
        yield 'status-new-all-fields' => [
            Uuid::v7(),
            ApplicationInstallationStatus::new, // application installation status
            CarbonImmutable::now(), // created at
            CarbonImmutable::now(), // updated at
            Uuid::v7(), // bitrix24 account id
            Uuid::v7(), // ?client contact person id
            Uuid::v7(), // ?partner contact person id
            Uuid::v7(), // ?partner id
            null, // external id
            ApplicationStatus::subscription(), // application status from bitrix24 api call response
            PortalLicenseFamily::nfr, // portal license family value
            null, // bitrix24 portal users count
            null, // comment
        ];
    }
}