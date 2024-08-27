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

namespace Bitrix24\SDK\Core\Commands;

use SplObjectStorage;

/**
 * Class CommandCollection
 *
 * @package Bitrix24\SDK\Core\Commands
 *
 * @method attach(Command $command)
 * @method Command current()
 */
class CommandCollection extends SplObjectStorage
{
}