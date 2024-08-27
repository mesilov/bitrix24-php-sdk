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

namespace Bitrix24\SDK\Tests\Application\Contracts\Bitrix24Partners\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Exceptions\Bitrix24PartnerNotFoundException;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Repository\Bitrix24PartnerRepositoryInterface;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Tests\Builders\DemoDataGenerator;
use Carbon\CarbonImmutable;
use Generator;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Bitrix24PartnerInterface::class)]
abstract class Bitrix24PartnerRepositoryInterfaceTest extends TestCase
{
    abstract protected function createBitrix24PartnerImplementation(
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
        ?string               $externalId): Bitrix24PartnerInterface;

    abstract protected function createBitrix24PartnerRepositoryImplementation(): Bitrix24PartnerRepositoryInterface;

    /**
     * @throws InvalidArgumentException
     * @throws Bitrix24PartnerNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24PartnerDataProvider')]
    #[TestDox('test save method')]
    final public function testSave(
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
        ?string               $externalId
    ): void
    {
        $b24Partner = $this->createBitrix24PartnerImplementation($uuid, $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $b24PartnerRepository = $this->createBitrix24PartnerRepositoryImplementation();

        $b24PartnerRepository->save($b24Partner);

        $res = $b24PartnerRepository->getById($b24Partner->getId());
        $this->assertEquals($b24Partner, $res);
    }

    /**
     * @throws InvalidArgumentException
     * @throws Bitrix24PartnerNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24PartnerDataProvider')]
    #[TestDox('test save with two bitrix24partner id')]
    final public function testSaveWithTwoBitrix24PartnerId(
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
        ?string               $externalId
    ): void
    {
        $b24Partner = $this->createBitrix24PartnerImplementation($uuid, $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $b24PartnerRepository = $this->createBitrix24PartnerRepositoryImplementation();

        $b24PartnerRepository->save($b24Partner);

        $res = $b24PartnerRepository->getById($b24Partner->getId());
        $this->assertEquals($b24Partner, $res);

        $secondB24Partner = $this->createBitrix24PartnerImplementation(Uuid::v7(), $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $this->expectException(InvalidArgumentException::class);
        $b24PartnerRepository->save($secondB24Partner);
    }

    /**
     * @throws InvalidArgumentException
     * @throws Bitrix24PartnerNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24PartnerDataProvider')]
    #[TestDox('test delete method')]
    final public function testDelete(
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
        ?string               $externalId
    ): void
    {
        $b24Partner = $this->createBitrix24PartnerImplementation($uuid, $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $b24PartnerRepository = $this->createBitrix24PartnerRepositoryImplementation();

        $b24Partner->markAsDeleted('delete partner');
        $b24PartnerRepository->save($b24Partner);

        $b24PartnerRepository->delete($b24Partner->getId());

        $this->assertNull($b24PartnerRepository->findByBitrix24PartnerId($bitrix24PartnerId));
    }

    /**
     * @throws InvalidArgumentException
     * @throws Bitrix24PartnerNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24PartnerDataProvider')]
    #[TestDox('test save method')]
    final public function testGetById(
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
        ?string               $externalId
    ): void
    {
        $b24Partner = $this->createBitrix24PartnerImplementation($uuid, $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $b24PartnerRepository = $this->createBitrix24PartnerRepositoryImplementation();

        $b24PartnerRepository->save($b24Partner);

        $res = $b24PartnerRepository->getById($b24Partner->getId());
        $this->assertEquals($b24Partner, $res);

        $this->expectException(Bitrix24PartnerNotFoundException::class);
        $b24PartnerRepository->getById(Uuid::v7());
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('bitrix24PartnerDataProvider')]
    #[TestDox('test findByBitrix24PartnerId method')]
    final public function testFindByBitrix24PartnerId(
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
        ?string               $externalId
    ): void
    {
        $b24Partner = $this->createBitrix24PartnerImplementation($uuid, $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $b24PartnerRepository = $this->createBitrix24PartnerRepositoryImplementation();

        $b24PartnerRepository->save($b24Partner);

        $res = $b24PartnerRepository->findByBitrix24PartnerId($b24Partner->getBitrix24PartnerId());
        $this->assertEquals($b24Partner, $res);


        $this->assertNull($b24PartnerRepository->findByBitrix24PartnerId(0));
    }

    #[Test]
    #[DataProvider('bitrix24PartnerDataProvider')]
    #[TestDox('test findByTitle method')]
    final public function testFindByTitle(
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
        ?string               $externalId
    ): void
    {
        $b24Partner = $this->createBitrix24PartnerImplementation($uuid, $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $b24PartnerRepository = $this->createBitrix24PartnerRepositoryImplementation();

        $b24PartnerRepository->save($b24Partner);

        $res = $b24PartnerRepository->findByTitle($b24Partner->getTitle());
        $this->assertEquals($b24Partner, $res[0]);

        $this->assertEmpty($b24PartnerRepository->findByTitle('test'));
    }

    #[Test]
    #[DataProvider('bitrix24PartnerDataProvider')]
    #[TestDox('test findByExternalId method')]
    final public function testFindByExternalId(
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
        ?string               $externalId
    ): void
    {
        $b24Partner = $this->createBitrix24PartnerImplementation($uuid, $createdAt, $updatedAt, $bitrix24PartnerStatus, $title, $bitrix24PartnerId, $site, $phoneNumber, $email, $openLineId, $externalId);
        $b24PartnerRepository = $this->createBitrix24PartnerRepositoryImplementation();

        $b24PartnerRepository->save($b24Partner);

        $res = $b24PartnerRepository->findByExternalId($b24Partner->getExternalId());
        $this->assertEquals($b24Partner, $res[0]);

        $this->assertEmpty($b24PartnerRepository->findByExternalId('test'));
    }

    /**
     * @throws NumberParseException
     * @throws InvalidArgumentException
     */
    public static function bitrix24PartnerDataProvider(): Generator
    {
        yield 'partner-status-active-all-fields' => [
            Uuid::v7(), //id
            CarbonImmutable::now(), // createdAt
            CarbonImmutable::now(), // updatedAt
            Bitrix24PartnerStatus::active,
            'Bitrix24 Partner LLC', // title
            12345, // bitrix24 partner id, optional
            'https://bitrix24-partner.com', // site, optional
            DemoDataGenerator::getMobilePhone(), // phone, optional
            DemoDataGenerator::getEmail(), // email, optional
            'open-line-id', // open line id, optional
            Uuid::v7()->toRfc4122(), // externalId, optional
            'comment', // comment, optional
        ];
    }
}