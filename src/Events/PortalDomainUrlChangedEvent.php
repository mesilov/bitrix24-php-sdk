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

namespace Bitrix24\SDK\Events;

use Symfony\Contracts\EventDispatcher\Event;

class PortalDomainUrlChangedEvent extends Event
{
    private string $oldDomainUrlHost;
    private string $newDomainUrlHost;

    /**
     * @param string $oldDomainUrlHost
     * @param string $newDomainUrlHost
     */
    public function __construct(string $oldDomainUrlHost, string $newDomainUrlHost)
    {
        $this->oldDomainUrlHost = parse_url($oldDomainUrlHost, PHP_URL_HOST);
        $this->newDomainUrlHost = parse_url($newDomainUrlHost, PHP_URL_HOST);
    }

    /**
     * @return string
     */
    public function getOldDomainUrlHost(): string
    {
        return $this->oldDomainUrlHost;
    }

    /**
     * @return string
     */
    public function getNewDomainUrlHost(): string
    {
        return $this->newDomainUrlHost;
    }
}