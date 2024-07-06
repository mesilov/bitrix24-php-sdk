<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Entity;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Carbon\CarbonImmutable;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class Bitrix24AccountInterfaceReferenceImplementationTest extends Bitrix24AccountInterfaceTest
{
    protected function createBitrix24AccountImplementation(
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
    ): Bitrix24AccountInterface
    {
        return new Bitrix24AccountReferenceEntityImplementation(
            $id,
            $bitrix24UserId,
            $isBitrix24UserAdmin,
            $memberId,
            $domainUrl,
            $accountStatus,
            $authToken,
            $createdAt,
            $updatedAt,
            $applicationVersion,
            $applicationScope
        );
    }
}