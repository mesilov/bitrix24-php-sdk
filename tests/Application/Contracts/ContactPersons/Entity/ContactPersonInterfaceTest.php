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

namespace Bitrix24\SDK\Tests\Application\Contracts\ContactPersons\Entity;

use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\FullName;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Tests\Builders\DemoDataGenerator;
use Carbon\CarbonImmutable;
use Darsyn\IP\Version\Multi as IP;
use Generator;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(ContactPersonInterface::class)]
abstract class ContactPersonInterfaceTest extends TestCase
{
    abstract protected function createContactPersonImplementation(
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
    ): ContactPersonInterface;

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getId method')]
    final public function testGetId(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($uuid, $contactPerson->getId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getStatus method')]
    final public function testGetStatus(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($contactPersonStatus, $contactPerson->getStatus());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsActive method')]
    final public function testMarkAsActive(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $contactPerson->markAsBlocked('block contact person');
        $this->assertEquals(ContactPersonStatus::blocked, $contactPerson->getStatus());
        $message = 'unblock contact person';
        $contactPerson->markAsActive($message);
        $this->assertEquals(ContactPersonStatus::active, $contactPerson->getStatus());
        $this->assertEquals($message, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsBlocked method')]
    final public function testMarkAsBlocked(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $message = 'block contact person';
        $contactPerson->markAsBlocked($message);
        $this->assertEquals(ContactPersonStatus::blocked, $contactPerson->getStatus());
        $this->assertEquals($message, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsDeleted method')]
    final public function testMarkAsDeleted(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $message = 'soft delete contact person';
        $contactPerson->markAsDeleted($message);
        $this->assertEquals(ContactPersonStatus::deleted, $contactPerson->getStatus());
        $this->assertEquals($message, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsDeleted method for blocked account')]
    final public function testMarkAsDeletedBlockedAccount(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $message = 'block contact person';
        $contactPerson->markAsBlocked($message);
        $this->assertEquals(ContactPersonStatus::blocked, $contactPerson->getStatus());
        $this->assertEquals($message, $contactPerson->getComment());
        $message = 'delete contact person';
        $contactPerson->markAsDeleted($message);
        $this->assertEquals(ContactPersonStatus::deleted, $contactPerson->getStatus());
        $this->assertEquals($message, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsDeleted method')]
    final public function testMarkAsDeletedDeletedAccount(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $message = 'soft delete contact person';
        $contactPerson->markAsDeleted($message);
        $this->expectException(InvalidArgumentException::class);
        $contactPerson->markAsDeleted($message);
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getFullName method')]
    final public function testGetFullName(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals(new FullName($name, $surname, $patronymic), $contactPerson->getFullName());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test changeFullName method')]
    final public function testChangeFullName(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $newFullName = DemoDataGenerator::getFullName();
        $contactPerson->changeFullName($newFullName);
        $this->assertEquals($newFullName, $contactPerson->getFullName());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUpdatedAt method')]
    final public function testGetUpdatedAt(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $contactPerson->markAsBlocked('test block');
        $this->assertEquals($createdAt, $contactPerson->getCreatedAt());
        $this->assertNotEquals($updatedAt, $contactPerson->getUpdatedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getCreatedAt method')]
    final public function testCreatedAt(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($createdAt, $contactPerson->getCreatedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getEmail method')]
    final public function testGetEmail(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($email, $contactPerson->getEmail());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test changeEmail method')]
    final public function testChangeEmail(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);

        $newEmail = DemoDataGenerator::getEmail();
        $contactPerson->changeEmail($newEmail);
        $this->assertEquals($newEmail, $contactPerson->getEmail());
        $this->assertNull($contactPerson->getEmailVerifiedAt());

        $newEmail = DemoDataGenerator::getEmail();
        $contactPerson->changeEmail($newEmail, true);
        $this->assertEquals($newEmail, $contactPerson->getEmail());
        $this->assertNotNull($contactPerson->getEmailVerifiedAt());
        $newEmail = DemoDataGenerator::getEmail();
        $contactPerson->changeEmail($newEmail);
        $this->assertEquals($newEmail, $contactPerson->getEmail());
        $this->assertNull($contactPerson->getEmailVerifiedAt());

        $newEmail = DemoDataGenerator::getEmail();
        $contactPerson->changeEmail($newEmail, false);
        $this->assertEquals($newEmail, $contactPerson->getEmail());
        $this->assertNull($contactPerson->getEmailVerifiedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markEmailAsVerified method')]
    final public function testMarkEmailAsVerified(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);

        $newEmail = DemoDataGenerator::getEmail();
        // email not verified
        $contactPerson->changeEmail($newEmail);
        $this->assertNull($contactPerson->getEmailVerifiedAt());

        $contactPerson->markEmailAsVerified();
        $this->assertNotNull($contactPerson->getEmailVerifiedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getMobilePhone method')]
    final public function testGetMobilePhone(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($phoneNumber, $contactPerson->getMobilePhone());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test changeMobilePhone method')]
    final public function testChangeMobilePhone(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);

        $phone = DemoDataGenerator::getMobilePhone();
        $contactPerson->changeMobilePhone($phone);
        $this->assertNull($contactPerson->getMobilePhoneVerifiedAt());

        $phone = DemoDataGenerator::getMobilePhone();
        $contactPerson->changeMobilePhone($phone, false);
        $this->assertNull($contactPerson->getMobilePhoneVerifiedAt());

        $phone = DemoDataGenerator::getMobilePhone();
        $contactPerson->changeMobilePhone($phone, true);
        $this->assertNotNull($contactPerson->getMobilePhoneVerifiedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getMobilePhoneVerifiedAt method')]
    final public function testGetMobilePhoneVerifiedAt(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($phoneNumber, $contactPerson->getMobilePhone());

        $phone = DemoDataGenerator::getMobilePhone();
        $contactPerson->changeMobilePhone($phone, true);
        $this->assertNotNull($contactPerson->getMobilePhoneVerifiedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markMobilePhoneAsVerified method')]
    final public function testMarkMobilePhoneAsVerified(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($phoneNumber, $contactPerson->getMobilePhone());

        $phone = DemoDataGenerator::getMobilePhone();
        $contactPerson->changeMobilePhone($phone);
        $this->assertNull($contactPerson->getMobilePhoneVerifiedAt());
        $contactPerson->markMobilePhoneAsVerified();
        $this->assertNotNull($contactPerson->getMobilePhoneVerifiedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getComment method')]
    final public function testGetComment(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $comment = 'block reason';
        $contactPerson->markAsBlocked($comment);
        $this->assertEquals($comment, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test setExternalId method')]
    final public function testSetExternalId(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $uuidV7 = Uuid::v7();

        $contactPerson->setExternalId($uuidV7->toRfc4122());
        $this->assertEquals($uuidV7->toRfc4122(), $contactPerson->getExternalId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getExternalId method')]
    final public function testGetExternalId(
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
    ): void
    {
        $externalId = null;
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertNull($contactPerson->getExternalId());

        $uuidV7 = Uuid::v7();
        $externalId = $uuidV7->toRfc4122();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($externalId, $contactPerson->getExternalId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getBitrix24UserId method')]
    final public function testGetBitrix24UserId(
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
    ): void
    {
        $bitrix24UserId = null;
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertNull($contactPerson->getBitrix24UserId());

        $bitrix24UserId = random_int(1, 100);
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($bitrix24UserId, $contactPerson->getBitrix24UserId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getBitrix24PartnerId method with happy path')]
    final public function testGetBitrix24PartnerId(
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
    ): void
    {
        if ($bitrix24PartnerUuid === null) {
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
            $this->assertNull($contactPerson->getBitrix24PartnerId());
        } else {
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
            $this->assertEquals($bitrix24PartnerUuid, $contactPerson->getBitrix24PartnerId());
        }
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test setBitrix24PartnerId method with happy path')]
    final public function testSetBitrix24PartnerId(
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
    ): void
    {
        if ($bitrix24PartnerUuid === null) {
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
            $this->assertNull($contactPerson->getBitrix24PartnerId());

            $bitrix24PartnerUuid = Uuid::v7();
            $contactPerson->setBitrix24PartnerId($bitrix24PartnerUuid);
            $this->assertEquals($bitrix24PartnerUuid, $contactPerson->getBitrix24PartnerId());
        } else {
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
            $this->assertEquals($bitrix24PartnerUuid, $contactPerson->getBitrix24PartnerId());
            $contactPerson->setBitrix24PartnerId(null);
            $this->assertNull($contactPerson->getBitrix24PartnerId());
        }
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUserAgent method')]
    final public function testGetUserAgent(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($userAgent, $contactPerson->getUserAgent());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUserAgentReferer method')]
    final public function testGetUserAgentReferer(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($userAgentReferer, $contactPerson->getUserAgentReferer());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUserAgentIp method')]
    final public function testGetUserAgentIp(
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerUuid, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($userAgentIp, $contactPerson->getUserAgentIp());
    }

    public static function contactPersonDataProvider(): Generator
    {
        $fullName = DemoDataGenerator::getFullName();

        yield 'valid-all-fields-by-default' => [
            Uuid::v7(),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            ContactPersonStatus::active,
            $fullName->name,
            $fullName->surname,
            $fullName->patronymic,
            DemoDataGenerator::getEmail(),
            CarbonImmutable::now(),
            'comment',
            DemoDataGenerator::getMobilePhone(),
            CarbonImmutable::now(),
            null,
            null,
            null,
            DemoDataGenerator::getUserAgent(),
            'https://bitrix24.com/apps/store?utm_source=bx24',
            DemoDataGenerator::getUserAgentIp()
        ];
        yield 'contact-person-is-partner-employee' => [
            Uuid::v7(),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            ContactPersonStatus::active,
            $fullName->name,
            $fullName->surname,
            $fullName->patronymic,
            DemoDataGenerator::getEmail(),
            CarbonImmutable::now(),
            'comment',
            DemoDataGenerator::getMobilePhone(),
            CarbonImmutable::now(),
            null,
            null,
            Uuid::v7(),
            DemoDataGenerator::getUserAgent(),
            'https://bitrix24.com/apps/store?utm_source=bx24',
            DemoDataGenerator::getUserAgentIp()
        ];
    }
}