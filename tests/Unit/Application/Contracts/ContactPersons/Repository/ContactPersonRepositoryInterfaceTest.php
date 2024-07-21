<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Repository;

use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Exceptions\ContactPersonNotFoundException;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Repository\ContactPersonRepositoryInterface;
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

#[CoversClass(ContactPersonRepositoryInterface::class)]
abstract class ContactPersonRepositoryInterfaceTest extends TestCase
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

    abstract protected function createContactPersonRepositoryImplementation(): ContactPersonRepositoryInterface;

    /**
     * @throws ContactPersonNotFoundException
     */
    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test save method for install start use case')]
    final public function testSave(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

        $repo->save($contactPerson);
        $acc = $repo->getById($contactPerson->getId());
        $this->assertEquals($contactPerson, $acc);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ContactPersonNotFoundException
     */
    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test delete method with happy path')]
    final public function testDelete(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

        $repo->save($contactPerson);
        $contactPerson = $repo->getById($contactPerson->getId());
        $contactPerson->markAsDeleted('soft delete account');
        $repo->delete($contactPerson->getId());

        $this->expectException(ContactPersonNotFoundException::class);
        $repo->getById($contactPerson->getId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test delete method with unsaved element')]
    final public function testDeleteWithUnsavedElement(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

        $this->expectException(ContactPersonNotFoundException::class);
        $repo->delete($contactPerson->getId());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getById method with happy path')]
    final public function testGetById(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

        $repo->save($contactPerson);
        $acc = $repo->getById($contactPerson->getId());
        $this->assertEquals($contactPerson, $acc);
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test getById method with non exist id')]
    final public function testGetByIdWithNonExist(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();

        $this->expectException(ContactPersonNotFoundException::class);
        $repo->getById(Uuid::v7());
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test find by email with happy path')]
    final public function testFindByEmailWithHappyPath(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

        $repo->save($contactPerson);
        $contactPersons = $repo->findByEmail($email);
        $this->assertEquals($contactPerson, $contactPersons[0]);
    }

    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test find by email with non exists email')]
    final public function testFindByEmailWithNonExistsEmail(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

        $repo->save($contactPerson);
        $contactPersons = $repo->findByEmail('this.email.doesnt.exists@b24.com');
        $this->assertEmpty($contactPersons);
    }

    #[Test]
    #[DataProvider('contactPersonWithDifferentStatusesDataProvider')]
    #[TestDox('test find by email with different statuses')]
    final public function testFindByEmailWithDifferentStatuses(
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
    ): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);

        $repo->save($contactPerson);
        $contactPersons = $repo->findByEmail($email, $contactPersonStatus);
        $this->assertEquals($contactPerson, $contactPersons[0]);
    }

    #[Test]
    #[DataProvider('contactPersonManyAccountsDataProvider')]
    #[TestDox('test find by email with verified email')]
    final public function testFindByEmailWithVerifiedEmail(array $items): void
    {
        $repo = $this->createContactPersonRepositoryImplementation();$emailToFind = null;
        $expectedContactPerson = null;
        foreach ($items as $item) {
            [$uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp] = $item;
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $userAgent, $userAgentReferer, $userAgentIp);
            $repo->save($contactPerson);
            if ($expectedContactPerson === null) {
                $expectedContactPerson = $contactPerson;
            }
        }

        $result = $repo->findByEmail($expectedContactPerson->getEmail());
        $this->assertCount(1, $result);
        $this->assertEquals($expectedContactPerson, $result[0]);

    }

    public static function contactPersonManyAccountsDataProvider(): Generator
    {
        $fullName = DemoDataGenerator::getFullName();

        yield 'many accounts with one verified email' =>
        [
            [
                [
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
                ],
                [
                    Uuid::v7(),
                    CarbonImmutable::now(),
                    CarbonImmutable::now(),
                    ContactPersonStatus::active,
                    $fullName->name,
                    $fullName->surname,
                    $fullName->patronymic,
                    DemoDataGenerator::getEmail(),
                    null,
                    'comment',
                    DemoDataGenerator::getMobilePhone(),
                    CarbonImmutable::now(),
                    null,
                    DemoDataGenerator::getUserAgent(),
                    'https://bitrix24.com/apps/store?utm_source=bx24',
                    DemoDataGenerator::getUserAgentIp()
                ],
                [
                    Uuid::v7(),
                    CarbonImmutable::now(),
                    CarbonImmutable::now(),
                    ContactPersonStatus::active,
                    $fullName->name,
                    $fullName->surname,
                    $fullName->patronymic,
                    DemoDataGenerator::getEmail(),
                    null,
                    'comment',
                    DemoDataGenerator::getMobilePhone(),
                    CarbonImmutable::now(),
                    null,
                    DemoDataGenerator::getUserAgent(),
                    'https://bitrix24.com/apps/store?utm_source=bx24',
                    DemoDataGenerator::getUserAgentIp()
                ]
            ]
        ];
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

    public static function contactPersonWithDifferentStatusesDataProvider(): Generator
    {
        $fullName = DemoDataGenerator::getFullName();

        yield 'active' => [
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

        yield 'blocked' => [
            Uuid::v7(),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            ContactPersonStatus::blocked,
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

        yield 'deleted' => [
            Uuid::v7(),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            ContactPersonStatus::deleted,
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