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

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Repository\ContactPersonRepositoryInterface;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Tests\Application\Contracts\ContactPersons\Repository\ContactPersonRepositoryInterfaceTest;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountReferenceEntityImplementation;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Entity\ContactPersonReferenceEntityImplementation;
use Carbon\CarbonImmutable;
use Darsyn\IP\Version\Multi as IP;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Log\NullLogger;
use Symfony\Component\Uid\Uuid;

#[CoversClass(ContactPersonRepositoryInterface::class)]
class InMemoryContactPersonRepositoryImplementationTest extends ContactPersonRepositoryInterfaceTest
{
    protected function createBitrix24AccountImplementation(
        Uuid                  $uuid,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $bitrix24AccountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): Bitrix24AccountInterface
    {
        return new Bitrix24AccountReferenceEntityImplementation(
            $uuid,
            $bitrix24UserId,
            $isBitrix24UserAdmin,
            $memberId,
            $domainUrl,
            $bitrix24AccountStatus,
            $authToken,
            $createdAt,
            $updatedAt,
            $applicationVersion,
            $applicationScope
        );
    }

    protected function createContactPersonImplementation(
        Uuid                $uuid,
        CarbonImmutable     $createdAt,
        CarbonImmutable     $updatedAt,
        ContactPersonStatus $contactPersonStatus,
        string              $name,
        ?string             $surname,
        ?string             $patronymic,
        ?string             $email,
        ?CarbonImmutable    $emailVerifiedAt,
        ?string             $comment,
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): ContactPersonInterface
    {
        return new ContactPersonReferenceEntityImplementation(
            $uuid,
            $createdAt,
            $updatedAt,
            $contactPersonStatus,
            $name,
            $surname,
            $patronymic,
            $email,
            $emailVerifiedAt,
            $comment,
            $phoneNumber,
            $mobilePhoneVerifiedAt,
            $externalId,
            $bitrix24UserId,
            $bitrix24PartnerId,
            $userAgent,
            $userAgentReferer,
            $userAgentIp
        );
    }

    protected function createContactPersonRepositoryImplementation(): ContactPersonRepositoryInterface
    {
        return new InMemoryContactPersonRepositoryImplementation(new NullLogger());
    }
}