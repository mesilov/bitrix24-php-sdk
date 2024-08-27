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

use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use Symfony\Contracts\EventDispatcher\Event;


class AuthTokenRenewedEvent extends Event
{
    private RenewedAuthToken $renewedToken;

    /**
     * AuthTokenRenewedEvent constructor.
     *
     * @param RenewedAuthToken $renewedToken
     */
    public function __construct(RenewedAuthToken $renewedToken)
    {
        $this->renewedToken = $renewedToken;
    }

    /**
     * @return RenewedAuthToken
     */
    public function getRenewedToken(): RenewedAuthToken
    {
        return $this->renewedToken;
    }
}
