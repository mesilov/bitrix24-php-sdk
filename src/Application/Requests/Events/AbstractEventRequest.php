<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events;

use Bitrix24\SDK\Application\Requests\AbstractRequest;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractEventRequest extends AbstractRequest
{
    protected string $eventCode;
    protected int $timestamp;
    protected array $eventPayload;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $payload = [];
        parse_str($request->getContent(), $payload);
        $this->eventPayload = $payload;

        $this->eventCode = $this->eventPayload['event'];
        $this->timestamp = (int)$this->eventPayload['ts'];
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getEventCode(): string
    {
        return $this->eventCode;
    }

    /**
     * @return array
     */
    public function getEventPayload(): array
    {
        return $this->eventPayload;
    }
}