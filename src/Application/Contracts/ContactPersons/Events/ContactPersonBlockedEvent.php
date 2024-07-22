<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ContactPersons\Events;

use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

class ContactPersonBlockedEvent extends Event
{
    public function __construct(
        public readonly Uuid            $contactPersonId,
        public readonly CarbonImmutable $timestamp)
    {
    }
}