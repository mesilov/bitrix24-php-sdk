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