<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Entity;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use Bitrix24\SDK\Services\Telephony\Call\Service\Call;
use Carbon\CarbonImmutable;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use Throwable;

#[CoversClass(Bitrix24AccountInterface::class)]
abstract class Bitrix24AccountInterfaceTest extends TestCase
{
    abstract protected function createBitrix24AccountImplementation(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): Bitrix24AccountInterface;

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getId method')]
    final public function testGetId(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($id, $ob->getId());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getBitrix24UserId method')]
    final public function testGetBitrix24UserId(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($bitrix24UserId, $ob->getBitrix24UserId());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test isBitrix24UserAdmin method')]
    final public function testisBitrix24UserAdmin(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($isBitrix24UserAdmin, $ob->isBitrix24UserAdmin());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getMemberId method')]
    final public function testGetMemberId(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($memberId, $ob->getMemberId());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getDomainUrl method')]
    final public function testGetDomainUrl(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($domainUrl, $ob->getDomainUrl());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getStatus method')]
    final public function testGetStatus(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($accountStatus, $ob->getStatus());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getAuthToken method')]
    final public function testGetAuthToken(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($authToken, $ob->getAuthToken());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test renewAuthToken method')]
    final public function testRenewAuthToken(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $newAuthToken = new AuthToken('access_token-2', 'refresh_token=2', 1609459202);
        $appStatus = ApplicationStatus::subscription();

        $renewedAuthToken = new RenewedAuthToken(
            $newAuthToken,
            $memberId,
            'https://bitrix24.com/client',
            'https://bitrix24.com/server',
            $appStatus,
            $domainUrl
        );
        $ob->renewAuthToken($renewedAuthToken);


        $this->assertEquals($newAuthToken, $ob->getAuthToken());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getApplicationVersion method')]
    final public function testGetApplicationVersion(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($applicationVersion, $ob->getApplicationVersion());
    }


    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test getApplicationScope method')]
    final public function testGetApplicationScope(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $this->assertEquals($applicationScope, $ob->getApplicationScope());
    }

    #[Test]
    #[DataProvider('bitrix24AccountDataProvider')]
    #[TestDox('test changeDomainUrl method')]
    final public function testChangeDomainUrl(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope
    ): void
    {
        $newDomainUrl = 'new-bitrix24.com';
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $ob->changeDomainUrl($newDomainUrl);
        $this->assertEquals($newDomainUrl, $ob->getDomainUrl());
    }

    #[Test]
    #[DataProvider('bitrix24AccountForInstallDataProvider')]
    #[TestDox('test applicationInstalled method')]
    final public function testApplicationInstalled(
        Uuid                  $id,
        int                   $bitrix24UserId,
        bool                  $isBitrix24UserAdmin,
        string                $memberId,
        string                $domainUrl,
        Bitrix24AccountStatus $accountStatus,
        AuthToken             $authToken,
        CarbonImmutable       $createdAt,
        CarbonImmutable       $updatedAt,
        int                   $applicationVersion,
        Scope                 $applicationScope,
        string                $applicationToken,
        ?Throwable            $exception
    ): void
    {
        if ($exception !== null) {
            $this->expectException($exception::class);
        }
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatus, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $ob->applicationInstalled($applicationToken);
        $this->assertTrue($ob->isApplicationTokenValid($applicationToken));
    }

    #[Test]
    #[DataProvider('bitrix24AccountForUninstallDataProvider')]
    #[TestDox('test applicationUninstalled method')]
    final public function testApplicationUninstalled(
        Uuid                   $id,
        int                    $bitrix24UserId,
        bool                   $isBitrix24UserAdmin,
        string                 $memberId,
        string                 $domainUrl,
        Bitrix24AccountStatus  $accountStatusForInstall,
        AuthToken              $authToken,
        CarbonImmutable        $createdAt,
        CarbonImmutable        $updatedAt,
        int                    $applicationVersion,
        Scope                  $applicationScope,
        string                 $applicationToken,
        ?Throwable             $exception
    ): void
    {
        if ($exception !== null) {
            $this->expectException($exception::class);
        }
        $ob = $this->createBitrix24AccountImplementation($id, $bitrix24UserId, $isBitrix24UserAdmin, $memberId, $domainUrl, $accountStatusForInstall, $authToken, $createdAt, $updatedAt, $applicationVersion, $applicationScope);
        $ob->applicationInstalled($applicationToken);
        $ob->applicationUninstalled($applicationToken);
        $this->assertEquals(Bitrix24AccountStatus::deleted, $ob->getStatus());
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

    public static function bitrix24AccountForInstallDataProvider(): Generator
    {
        yield 'empty-application-token' => [
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