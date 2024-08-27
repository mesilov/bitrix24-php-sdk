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

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ApplicationInstallations\Repository;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationInterface;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Repository\ApplicationInstallationRepositoryInterface;
use Bitrix24\SDK\Application\PortalLicenseFamily;
use Bitrix24\SDK\Tests\Application\Contracts\ApplicationInstallations\Repository\ApplicationInstallationRepositoryInterfaceTest;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationReferenceEntityImplementation;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Log\NullLogger;
use Symfony\Component\Uid\Uuid;

#[CoversClass(ApplicationInstallationRepositoryInterface::class)]
class InMemoryApplicationInstallationRepositoryImplementationTest extends ApplicationInstallationRepositoryInterfaceTest
{
    protected function createApplicationInstallationImplementation(Uuid $uuid, ApplicationInstallationStatus $applicationInstallationStatus, CarbonImmutable $createdAt, CarbonImmutable $updatedAt, Uuid $bitrix24AccountUuid, ApplicationStatus $applicationStatus, PortalLicenseFamily $portalLicenseFamily, ?int $portalUsersCount, ?Uuid $clientContactPersonUuid, ?Uuid $partnerContactPersonUuid, ?Uuid $partnerUuid, ?string $externalId,): ApplicationInstallationInterface
    {
        return new ApplicationInstallationReferenceEntityImplementation(
            $uuid,
            $applicationInstallationStatus,
            $createdAt,
            $updatedAt,
            $bitrix24AccountUuid,
            $applicationStatus,
            $portalLicenseFamily,
            $portalUsersCount,
            $clientContactPersonUuid,
            $partnerContactPersonUuid,
            $partnerUuid,
            $externalId,
        );
    }

    protected function createApplicationInstallationRepositoryImplementation(): ApplicationInstallationRepositoryInterface
    {
        return new InMemoryApplicationInstallationRepositoryImplementation(new NullLogger());
    }
}