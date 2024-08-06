<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Partners\Entity;

use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerStatus;
use Bitrix24\SDK\Tests\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerInterfaceTest;
use Carbon\CarbonImmutable;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Bitrix24PartnerInterface::class)]
class Bitrix24PartnerInterfaceReferenceImplementationTest extends Bitrix24PartnerInterfaceTest
{
    protected function createBitrix24PartnerImplementation(
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
        ?string               $externalId): Bitrix24PartnerInterface
    {
        return new Bitrix24PartnerReferenceEntityImplementation(
            $uuid,
            $createdAt,
            $updatedAt,
            $bitrix24PartnerStatus,
            $title,
            $bitrix24PartnerId,
            $site,
            $phoneNumber,
            $email,
            $openLineId,
            $externalId
        );
    }
}