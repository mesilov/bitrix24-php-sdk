<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Events;

use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

class Bitrix24PartnerPartnerIdChangedEvent extends Event
{
    public function __construct(
        public readonly Uuid            $bitrix24PartnerId,
        public readonly CarbonImmutable $timestamp,
        public readonly ?int            $previousPartnerId,
        public readonly ?int            $currentPartnerId)
    {
    }
}