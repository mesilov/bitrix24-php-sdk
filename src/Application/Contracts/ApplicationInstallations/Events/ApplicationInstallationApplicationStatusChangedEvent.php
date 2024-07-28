<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Events;

use Bitrix24\SDK\Application\ApplicationStatus;
use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

class ApplicationInstallationApplicationStatusChangedEvent extends Event
{
    public function __construct(
        public readonly Uuid              $applicationInstallationId,
        public readonly CarbonImmutable   $timestamp,
        public readonly ApplicationStatus $applicationStatus)
    {
    }
}