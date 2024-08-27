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

namespace Bitrix24\SDK\Tests\Application\Contracts\ContactPersons\Repository;

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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $acc = $contactPersonRepository->getById($contactPerson->getId());
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $contactPerson = $contactPersonRepository->getById($contactPerson->getId());
        $contactPerson->markAsDeleted('soft delete account');

        $contactPersonRepository->delete($contactPerson->getId());

        $this->expectException(ContactPersonNotFoundException::class);
        $contactPersonRepository->getById($contactPerson->getId());
    }

    /**
     * @throws InvalidArgumentException
     */
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);
        $this->expectException(ContactPersonNotFoundException::class);
        $contactPersonRepository->delete($contactPerson->getId());
    }

    /**
     * @throws ContactPersonNotFoundException
     */
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $acc = $contactPersonRepository->getById($contactPerson->getId());
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();

        $this->expectException(ContactPersonNotFoundException::class);
        $contactPersonRepository->getById(Uuid::v7());
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $contactPersons = $contactPersonRepository->findByEmail($email);
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $contactPersons = $contactPersonRepository->findByEmail('this.email.doesnt.exists@b24.com');
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
        ?PhoneNumber        $phoneNumber,
        ?CarbonImmutable    $mobilePhoneVerifiedAt,
        ?string             $externalId,
        ?int                $bitrix24UserId,
        ?Uuid               $bitrix24PartnerId,
        ?string             $userAgent,
        ?string             $userAgentReferer,
        ?IP                 $userAgentIp
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $bitrix24PartnerId, $externalId, $bitrix24UserId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $contactPersons = $contactPersonRepository->findByEmail($email, $contactPersonStatus);
        $this->assertEquals($contactPerson, $contactPersons[0]);
    }

    #[Test]
    #[DataProvider('contactPersonManyAccountsDataProvider')]
    #[TestDox('test find by email with verified email')]
    final public function testFindByEmailWithVerifiedEmail(array $items): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $expectedContactPerson = null;
        foreach ($items as $item) {
            [$uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp] = $item;
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);
            $contactPersonRepository->save($contactPerson);
            if (!$expectedContactPerson instanceof ContactPersonInterface) {
                $expectedContactPerson = $contactPerson;
            }
        }

        $result = $contactPersonRepository->findByEmail($expectedContactPerson->getEmail(), null, true);
        $this->assertCount(1, $result);
        $this->assertEquals($expectedContactPerson, $result[0]);

    }

    #[Test]
    #[DataProvider('contactPersonManyAccountsDataProvider')]
    #[TestDox('test find by phone with verified phone')]
    final public function testFindByEmailWithVerifiedPhone(array $items): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $expectedContactPerson = null;
        foreach ($items as $item) {
            [$uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp] = $item;
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);
            $contactPersonRepository->save($contactPerson);
            if (!$expectedContactPerson instanceof ContactPersonInterface) {
                $expectedContactPerson = $contactPerson;
            }
        }

        $result = $contactPersonRepository->findByPhone($expectedContactPerson->getMobilePhone(), null, true);
        $this->assertCount(1, $result);
        $this->assertEquals($expectedContactPerson, $result[0]);

    }

    /**
     * @throws ContactPersonNotFoundException
     */
    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test findByExternalId method with happy path')]
    final public function testFindByExternalId(
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
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $externalId = Uuid::v7();
        $contactPerson->setExternalId($externalId->toRfc4122());

        $contactPersonRepository->save($contactPerson);
        $acc = $contactPersonRepository->findByExternalId($externalId->toRfc4122());
        $this->assertEquals($contactPerson, $acc[0]);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test findByExternalId with non exist id')]
    final public function testFindByExternalIdWithNonExistsId(
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
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $this->assertEquals([], $contactPersonRepository->findByExternalId(Uuid::v7()->toRfc4122()));
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('contactPersonDataProvider')]
    #[TestDox('test findByExternalId with empty id')]
    final public function testFindByExternalIdWithEmptyId(
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
    ): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $phoneNumber, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);

        $contactPersonRepository->save($contactPerson);
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $contactPersonRepository->findByExternalId('');
    }

    #[Test]
    #[DataProvider('contactPersonManyAccountsDataProvider')]
    #[TestDox('test findByExternalId with multiple installs by same contact person')]
    final public function testFindByExternalIdWithMultipleInstalls(array $items): void
    {
        $contactPersonRepository = $this->createContactPersonRepositoryImplementation();
        $expectedContactPersons = [];
        $expectedExternalId = null;
        foreach ($items as $item) {
            [$uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp] = $item;
            $contactPerson = $this->createContactPersonImplementation($uuid, $createdAt, $updatedAt, $contactPersonStatus, $name, $surname, $patronymic, $email, $emailVerifiedAt, $comment, $mobilePhone, $mobilePhoneVerifiedAt, $externalId, $bitrix24UserId, $bitrix24PartnerId, $userAgent, $userAgentReferer, $userAgentIp);
            $contactPersonRepository->save($contactPerson);
            if ($contactPerson->getExternalId() !== null) {
                $expectedContactPersons[] = $contactPerson;
                if ($expectedExternalId === null) {
                    $expectedExternalId = $contactPerson->getExternalId();
                }
            }
        }

        $result = $contactPersonRepository->findByExternalId($expectedExternalId);
        $this->assertCount(2, $result);
        $this->assertEquals($expectedContactPersons, $result);

    }

    public static function contactPersonManyAccountsDataProvider(): Generator
    {
        $fullName = DemoDataGenerator::getFullName();
        $externalId = Uuid::v7()->toRfc4122();
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
                    null,
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
                    null,
                    $externalId,
                    null,
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
                    null,
                    $externalId,
                    null,
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
            null,
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
            null,
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
            null,
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
            null,
            null,
            DemoDataGenerator::getUserAgent(),
            'https://bitrix24.com/apps/store?utm_source=bx24',
            DemoDataGenerator::getUserAgentIp()
        ];
    }
}