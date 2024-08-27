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

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Partners\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Repository\Bitrix24AccountRepositoryInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Repository\Bitrix24PartnerRepositoryInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Repository\ContactPersonRepositoryInterface;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Tests\Application\Contracts\Bitrix24Partners\Repository\Bitrix24PartnerRepositoryInterfaceTest;
use Bitrix24\SDK\Tests\Application\Contracts\ContactPersons\Repository\ContactPersonRepositoryInterfaceTest;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountReferenceEntityImplementation;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerReferenceEntityImplementation;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Entity\ContactPersonReferenceEntityImplementation;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Repository\InMemoryContactPersonRepositoryImplementation;
use Carbon\CarbonImmutable;
use Darsyn\IP\Version\Multi as IP;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Log\NullLogger;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Bitrix24PartnerRepositoryInterface::class)]
class InMemoryBitrix24PartnerRepositoryImplementationTest extends Bitrix24PartnerRepositoryInterfaceTest
{
    protected function createBitrix24PartnerImplementation(
        Uuid                  $uuid,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        Bitrix24PartnerStatus $bitrix24PartnerStatus,
        string                $title,
        ?int                  $bitrix24PartnerId,
        ?string               $site,
        ?PhoneNumber          $phoneNumber,
        ?string               $email,
        ?string               $openLineId,
        ?string               $externalId): Bitrix24PartnerInterface
    {
        return new Bitrix24PartnerReferenceEntityImplementation(
            $uuid,
            $createdAt,
            $updatedAt,
            $bitrix24PartnerStatus,
            $title,
            $bitrix24PartnerId,
            $site,
            $phoneNumber,
            $email,
            $openLineId,
            $externalId);
    }

    protected function createBitrix24PartnerRepositoryImplementation(): Bitrix24PartnerRepositoryInterface
    {
        return new InMemoryBitrix24PartnerRepositoryImplementation(new NullLogger());
    }
}