<?php

namespace Bitrix24\SDK\Services\Main\Common;

use Bitrix24\SDK\Services\Main\Result\EventHandlerItemResult;

readonly class EventHandlerMetadata
{
    public function __construct(
        public string $code,
        public string $handlerUrl,
        public int    $userId,
        public ?array $options = null
    )
    {
    }

    public function isInstalled(EventHandlerItemResult $eventHandlerItemResult): bool
    {
        return strtoupper($eventHandlerItemResult->event) === strtoupper($this->code) &&
            $eventHandlerItemResult->handler === $this->handlerUrl;
    }
}