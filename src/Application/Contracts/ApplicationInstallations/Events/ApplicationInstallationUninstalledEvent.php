<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Events;

use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

class ApplicationInstallationUninstalledEvent extends Event
{
    public function __construct(
        public readonly Uuid            $applicationInstallationId,
        public readonly CarbonImmutable $timestamp,
        public readonly Uuid            $bitrix24AccountId,
        public readonly ?Uuid           $contactPersonId,
        public readonly ?Uuid           $bitrix24PartnerContactPersonId,
        public readonly ?Uuid           $bitrix24PartnerId,
        public readonly ?string         $externalId)
    {
    }
}