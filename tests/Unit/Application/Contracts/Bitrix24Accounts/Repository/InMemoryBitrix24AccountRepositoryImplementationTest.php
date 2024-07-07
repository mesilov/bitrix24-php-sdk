<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Repository;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Repository\Bitrix24AccountRepositoryInterface;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterfaceTest;
use Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountReferenceEntityImplementation;
use Carbon\CarbonImmutable;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Bitrix24AccountRepositoryInterface::class)]
class InMemoryBitrix24AccountRepositoryImplementationTest extends Bitrix24AccountRepositoryInterfaceTest
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

    protected function createBitrix24AccountRepositoryImplementation(): Bitrix24AccountRepositoryInterface
    {
        return new InMemoryBitrix24AccountRepositoryImplementation(Fabric::getLogger());
    }
}