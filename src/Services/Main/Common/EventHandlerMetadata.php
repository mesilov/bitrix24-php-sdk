<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

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