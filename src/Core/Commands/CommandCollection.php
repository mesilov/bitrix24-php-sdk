<?php

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