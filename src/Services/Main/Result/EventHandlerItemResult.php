<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $event
 * @property-read string $handler
 * @property-read string $auth_type
 * @property-read int    $offline
 */
class EventHandlerItemResult extends AbstractItem
{
}