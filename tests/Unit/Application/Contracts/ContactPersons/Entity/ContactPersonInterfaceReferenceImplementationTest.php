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
use Bitrix24\SDK\Tests\Application\Contracts\ContactPersons\Entity\ContactPersonInterfaceTest;
use Carbon\CarbonImmutable;
use Darsyn\IP\Version\Multi as IP;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Uid\Uuid;

#[CoversClass(ContactPersonReferenceEntityImplementation::class)]
class ContactPersonInterfaceReferenceImplementationTest extends ContactPersonInterfaceTest
{
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
        ?Uuid               $bitrix24PartnerUuid,
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
            $bitrix24PartnerUuid,
            $userAgent,
            $userAgentReferer,
            $userAgentIp
        );
    }
}