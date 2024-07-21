<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Entity;

use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
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
        ?PhoneNumber        $mobilePhone,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
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
            $mobilePhone,
            $mobilePhoneVerifiedAt,
            $externalId,
            $userAgent,
            $userAgentReferer,
            $userAgentIp
        );
    }
}