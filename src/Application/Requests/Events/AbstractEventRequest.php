<?php

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

    /**
     * @param Request $request
     */
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