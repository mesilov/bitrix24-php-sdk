<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Events;

use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

class Bitrix24AccountDomainUrlChangedEvent extends Event
{
    public function __construct(
        public readonly Uuid            $bitrix24AccountId,
        public readonly CarbonImmutable $timestamp)
    {
    }
}