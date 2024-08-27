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

namespace Bitrix24\SDK\Tests\Application\Contracts\Bitrix24Accounts\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Exceptions\Bitrix24AccountNotFoundException;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Repository\Bitrix24AccountRepositoryInterface;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Carbon\CarbonImmutable;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Bitrix24AccountInterface::class)]
abstract class Bitrix24AccountRepositoryInterfaceTest extends TestCase
{
    abstract protected function createBitrix24AccountImplementation(
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
    ): Bitrix24AccountInterface;

    abstract protected function createBitrix24AccountRepositoryImplementation(): Bitrix24AccountRepositoryInterface;

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test save method for install start use case')]
    final public function testSave(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);

        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($bitrix24Account->getId());
        $this->assertEquals($bitrix24Account, $acc);
    }

    #[Test]
    #[TestDox('test getById method with non existing account')]
    public function testGetByIdNotExists(): void
    {
        $this->expectException(Bitrix24AccountNotFoundException::class);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();
        $bitrix24AccountRepository->getById(Uuid::v7());
    }

    /**
     * @throws InvalidArgumentException
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test delete method for happy path')]
    final public function testDeleteHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        // application installed
        $applicationToken = 'application_token';
        $bitrix24Account->applicationInstalled($applicationToken);
        $bitrix24AccountRepository->save($bitrix24Account);

        // a few moments later
        $account = $bitrix24AccountRepository->getById($uuid);
        $account->applicationUninstalled($applicationToken);

        $bitrix24AccountRepository->save($bitrix24Account);

        $bitrix24AccountRepository->delete($uuid);

        $this->expectException(Bitrix24AccountNotFoundException::class);
        $bitrix24AccountRepository->getById($uuid);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test delete method for account not in deleted state')]
    final public function testDeleteNotInDeletedState(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);

        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $this->expectException(InvalidArgumentException::class);
        $bitrix24AccountRepository->delete($uuid);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Test]
    #[TestDox('test delete method with non existing account')]
    public function testDeleteWithIdNotExists(): void
    {
        $this->expectException(Bitrix24AccountNotFoundException::class);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();
        $bitrix24AccountRepository->delete(Uuid::v7());
    }

    #[Test]
    #[TestDox('test findOneAdminByMemberId method with empty member_id')]
    public function testFindOneAdminByMemberIdWithEmptyArgs(): void
    {
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $bitrix24AccountRepository->findOneAdminByMemberId('');
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findOneAdminByMemberId method with happy path')]
    final public function testFindOneAdminByMemberIdWithHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);


        $found = $bitrix24AccountRepository->findOneAdminByMemberId($memberId);
        $this->assertEquals($acc, $found);
    }

    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findOneAdminByMemberId method with simple user')]
    final public function testFindOneAdminByMemberIdWithSimpleUser(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, false, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findOneAdminByMemberId($memberId);
        $this->assertNull($found);
    }

    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByMemberId method with happy path')]
    final public function testFindByMemberIdWithHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByMemberId($memberId);
        $this->assertEquals($bitrix24Account, $found[0]);
    }

    #[Test]
    #[TestDox('test findByMemberId method with happy path - not found')]
    final public function testFindByMemberIdWithHappyPathNotFound(): void
    {
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();
        $found = $bitrix24AccountRepository->findByMemberId('member_id');
        $this->assertEquals([], $found);
    }

    #[Test]
    #[TestDox('test findByMemberId method with empty member id')]
    final public function testFindByMemberIdWithEmptyMemberId(): void
    {
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $bitrix24AccountRepository->findByMemberId('');
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByMemberId method with blocked account happy path')]
    final public function testFindByMemberIdWithBlockedAccountHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);
        $acc->markAsBlocked('block by admin');
        $bitrix24AccountRepository->save($acc);

        $found = $bitrix24AccountRepository->findByMemberId($memberId, Bitrix24AccountStatus::blocked);
        $this->assertEquals($acc, $found[0]);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByMemberId method with account status but account not found')]
    final public function testFindByMemberIdWithAccountStatusAccountNotFound(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByMemberId($memberId, Bitrix24AccountStatus::blocked);
        $this->assertEquals([], $found);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByMemberId method with is admin happy path')]
    final public function testFindByMemberIdWithIsAdminHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByMemberId($memberId, null, true);
        $this->assertEquals($acc, $found[0]);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByMemberId method with is admin - not found')]
    final public function testFindByMemberIdWithIsAdminNotFound(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, false, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByMemberId($memberId, null, true);
        $this->assertEquals([], $found);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByMemberId method with all args')]
    final public function testFindByMemberIdWithAllArgs(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, false, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByMemberId($memberId, Bitrix24AccountStatus::new, false);
        $this->assertEquals($acc, $found[0]);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByDomain method with happy path')]
    final public function testFindByDomainWithHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByDomain($domainUrl);
        $this->assertEquals($bitrix24Account, $found[0]);
    }

    #[Test]
    #[TestDox('test findByDomain method with happy path - not found')]
    final public function testFindByDomainWithHappyPathNotFound(): void
    {
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();
        $found = $bitrix24AccountRepository->findByDomain('test.com');
        $this->assertEquals([], $found);
    }

    #[Test]
    #[TestDox('test findByDomain method with empty domain url')]
    final public function testFindByDomainWithEmptyDomainUrl(): void
    {
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();
        $this->expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $bitrix24AccountRepository->findByDomain('');
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByDomain method with blocked account happy path')]
    final public function testFindByDomainWithBlockedAccountHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);
        $acc->markAsBlocked('block by admin');
        $bitrix24AccountRepository->save($acc);

        $found = $bitrix24AccountRepository->findByDomain($domainUrl, Bitrix24AccountStatus::blocked);
        $this->assertEquals($acc, $found[0]);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByDomain method with account status but account not found')]
    final public function testFindByDomainWithAccountStatusAccountNotFound(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByDomain($domainUrl, Bitrix24AccountStatus::blocked);
        $this->assertEquals([], $found);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     * @throws InvalidArgumentException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByDomain method with is admin happy path')]
    final public function testFindByDomainWithIsAdminHappyPath(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByDomain($domainUrl, null, true);
        $this->assertEquals($acc, $found[0]);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByDomain method with is admin - not found')]
    final public function testFindByDomainWithIsAdminNotFound(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, false, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByDomain($memberId, null, true);
        $this->assertEquals([], $found);
    }

    /**
     * @throws Bitrix24AccountNotFoundException
     */
    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test findByDomain method with all args')]
    final public function testFindByDomainWithAllArgs(
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
    ): void
    {
        $bitrix24Account = $this->createBitrix24AccountImplementation($uuid, $bitrix24UserId, false, $memberId, $domainUrl, $bitrix24AccountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $bitrix24AccountRepository = $this->createBitrix24AccountRepositoryImplementation();

        $bitrix24AccountRepository->save($bitrix24Account);

        $acc = $bitrix24AccountRepository->getById($uuid);
        $this->assertEquals($bitrix24Account, $acc);

        $found = $bitrix24AccountRepository->findByDomain($domainUrl, Bitrix24AccountStatus::new, false);
        $this->assertEquals($acc, $found[0]);
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public static function bitrix24AccountWithStatusNewDataProvider(): Generator
    {
        yield 'valid-update' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::new,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token',
            2,
            new Scope(['crm', 'task', 'telephony']),
            null
        ];
        yield 'valid-update-same-scope' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::new,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token',
            2,
            new Scope(['task', 'crm']),
            null
        ];
        yield 'valid-downgrade-scope' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::new,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope([]),
            'application_token',
            2,
            new Scope(['task', 'crm']),
            null
        ];
        yield 'invalid-version' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::new,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token',
            1,
            new Scope(['crm', 'task', 'telephony']),
            new InvalidArgumentException()
        ];
    }

    public static function bitrix24AccountForUninstallDataProvider(): Generator
    {
        yield 'empty-application-token' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::active,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            '',
            new InvalidArgumentException()
        ];

        yield 'account-status-new' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::new,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token_value',
            null
        ];
        yield 'account-status-active' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::active,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token_value',
            new InvalidArgumentException()

        ];
        yield 'account-status-blocked' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::blocked,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token_value',
            new InvalidArgumentException()
        ];
        yield 'account-status-deleted' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::deleted,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token_value',
            new InvalidArgumentException()
        ];
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public static function bitrix24AccountForInstallDataProvider(): Generator
    {
        yield 'account-status-new' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::new,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task']),
            'application_token_value',
            null
        ];
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public static function bitrix24AccountDataProvider(): Generator
    {
        yield 'account-status-new' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::new,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task'])
        ];
        yield 'account-status-active' => [
            Uuid::v7(),
            12345,
            true,
            'member123',
            'https://example.com',
            Bitrix24AccountStatus::active,
            new AuthToken('access_token', 'refresh_token', 1609459200),
            CarbonImmutable::now(),
            CarbonImmutable::now(),
            1,
            new Scope(['crm', 'task'])
        ];
    }
}