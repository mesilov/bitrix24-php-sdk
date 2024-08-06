<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Events;

use Carbon\CarbonImmutable;
use libphonenumber\PhoneNumber;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

class Bitrix24PartnerPhoneChangedEvent extends Event
{
    public function __construct(
        public readonly Uuid            $bitrix24PartnerId,
        public readonly CarbonImmutable $timestamp,
        public readonly ?PhoneNumber    $previousPhone,
        public readonly ?PhoneNumber    $currentPhone)
    {
    }
}