<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Entity;

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
        ?PhoneNumber        $mobilePhone,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): ContactPersonInterface;

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getId method')]
    final public function testGetId(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($id, $contactPerson->getId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getStatus method')]
    final public function testGetStatus(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($contactPersonStatus, $contactPerson->getStatus());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsActive method')]
    final public function testMarkAsActive(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
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
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $message = 'block contact person';
        $contactPerson->markAsBlocked($message);
        $this->assertEquals(ContactPersonStatus::blocked, $contactPerson->getStatus());
        $this->assertEquals($message, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsDeleted method')]
    final public function testMarkAsDeleted(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $message = 'soft delete contact person';
        $contactPerson->markAsDeleted($message);
        $this->assertEquals(ContactPersonStatus::deleted, $contactPerson->getStatus());
        $this->assertEquals($message, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markAsDeleted method for blocked account')]
    final public function testMarkAsDeletedBlockedAccount(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
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
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $message = 'soft delete contact person';
        $contactPerson->markAsDeleted($message);
        $this->expectException(InvalidArgumentException::class);
        $contactPerson->markAsDeleted($message);
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getFullName method')]
    final public function testGetFullName(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals(new FullName($name, $surname, $patronymic), $contactPerson->getFullName());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test changeFullName method')]
    final public function testChangeFullName(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $newFullName = DemoDataGenerator::getFullName();
        $contactPerson->changeFullName($newFullName);
        $this->assertEquals($newFullName, $contactPerson->getFullName());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUpdatedAt method')]
    final public function testGetUpdatedAt(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $contactPerson->markAsBlocked('test block');
        $this->assertEquals($createdAt, $contactPerson->getCreatedAt());
        $this->assertNotEquals($updatedAt, $contactPerson->getUpdatedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getCreatedAt method')]
    final public function testCreatedAt(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($createdAt, $contactPerson->getCreatedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getEmail method')]
    final public function testGetEmail(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($email, $contactPerson->getEmail());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test changeEmail method')]
    final public function testChangeEmail(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

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
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

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
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($mobilePhone, $contactPerson->getMobilePhone());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test changeMobilePhone method')]
    final public function testChangeMobilePhone(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

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
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($mobilePhone, $contactPerson->getMobilePhone());

        $phone = DemoDataGenerator::getMobilePhone();
        $contactPerson->changeMobilePhone($phone, true);
        $this->assertNotNull($contactPerson->getMobilePhoneVerifiedAt());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test markMobilePhoneAsVerified method')]
    final public function testMarkMobilePhoneAsVerified(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($mobilePhone, $contactPerson->getMobilePhone());

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
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $comment = 'block reason';
        $contactPerson->markAsBlocked($comment);
        $this->assertEquals($comment, $contactPerson->getComment());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test setExternalId method')]
    final public function testSetExternalId(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $uuid = Uuid::v7();

        $contactPerson->setExternalId($uuid->toRfc4122());
        $this->assertEquals($uuid->toRfc4122(), $contactPerson->getExternalId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getExternalId method')]
    final public function testGetExternalId(
        Uuid                $id,
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
    ): void
    {
        $externalId = null;
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertNull($contactPerson->getExternalId());

        $uuid = Uuid::v7();
        $externalId = $uuid->toRfc4122();
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($externalId, $contactPerson->getExternalId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUserAgent method')]
    final public function testGetUserAgent(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($userAgent, $contactPerson->getUserAgent());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUserAgentReferer method')]
    final public function testGetUserAgentReferer(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->assertEquals($userAgentReferer, $contactPerson->getUserAgentReferer());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getUserAgentIp method')]
    final public function testGetUserAgentIp(
        Uuid                $id,
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
    ): void
    {
        $contactPerson = $this->createContactPersonImplementation($id, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
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
            DemoDataGenerator::getUserAgent(),
            'https://bitrix24.com/apps/store?utm_source=bx24',
            DemoDataGenerator::getUserAgentIp()
        ];
    }
}