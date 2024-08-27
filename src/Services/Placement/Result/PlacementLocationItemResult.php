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

namespace Bitrix24\SDK\Services\Placement\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $placement
 * @property-read string $handler
 * @property-read string $title
 * @property-read string $description
 * @property-read array  $options
 * @property-read array  $langAll
 */
class PlacementLocationItemResult extends AbstractItem
{
}