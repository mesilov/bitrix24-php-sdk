<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events;

use Bitrix24\SDK\Application\Requests\AbstractRequest;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractEventRequest extends AbstractRequest implements EventInterface
{
    protected string $eventCode;

    protected int $timestamp;

    protected array $eventPayload;

    protected int $eventId;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $payload = [];
        parse_str($request->getContent(), $payload);
        $this->eventPayload = $payload;

        $this->eventCode = $this->eventPayload['event'];
        $this->timestamp = (int)$this->eventPayload['ts'];
        $this->eventId = (int)$this->eventPayload['event_id'];
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getEventCode(): string
    {
        return $this->eventCode;
    }

    public function getEventPayload(): array
    {
        return $this->eventPayload;
    }

    public function getAuth(): EventAuthItem
    {
        return new EventAuthItem($this->eventPayload['auth']);
    }
}