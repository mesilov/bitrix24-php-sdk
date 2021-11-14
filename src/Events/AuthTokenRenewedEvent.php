<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Events;

use Bitrix24\SDK\Core\Response\DTO\RenewedAccessToken;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AuthTokenRenewedEvent
 *
 * @package Bitrix24\SDK\Events
 */
class AuthTokenRenewedEvent extends Event
{
    /**
     * @var RenewedAccessToken
     */
    private $renewedToken;

    /**
     * AuthTokenRenewedEvent constructor.
     *
     * @param RenewedAccessToken $renewedToken
     */
    public function __construct(RenewedAccessToken $renewedToken)
    {
        $this->renewedToken = $renewedToken;
    }

    /**
     * @return RenewedAccessToken
     */
    public function getRenewedToken(): RenewedAccessToken
    {
        return $this->renewedToken;
    }
}
