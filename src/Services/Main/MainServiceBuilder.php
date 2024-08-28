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

namespace Bitrix24\SDK\Services\Main;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Main\Service\EventManager;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Services\Main\Service\Event;

/**
 * Class MainServiceBuilder
 *
 * @package Bitrix24\SDK\Services\Main
 */
class MainServiceBuilder extends AbstractServiceBuilder
{
    public function main(): Main
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Main($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function event(): Event
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Event($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function eventManager(): EventManager
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new EventManager(
                new Event($this->core, $this->log),
                $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}