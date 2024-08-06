<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\Events;

use Symfony\Contracts\EventDispatcher\Event;

interface AggregateRootEventsEmitterInterface
{
    /**
     * @return Event[]
     */
    public function emitEvents(): array;
}