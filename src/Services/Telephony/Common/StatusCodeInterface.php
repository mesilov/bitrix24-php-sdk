<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

interface StatusCodeInterface
{
    public const statusSuccessfulCall  = 'VI_STATUS_200';
    public const statusMissedCall = 'VI_STATUS_304';
    public const statusRejected = 'VI_STATUS_603';
    public const statusCanceledCall = 'VI_STATUS_603-S';
    public const statusForbidden = 'VI_STATUS_403';
    public const statusWrongNumber = 'VI_STATUS_404';
    public const statusBusy = 'VI_STATUS_486';
    public const statusThisRouteIsNotAvailable = 'VI_STATUS_484';
    public const statusTemporarilyUnavailable = 'VI_STATUS_480';
    public const statusInsufficientFundsInTheAccount ='VI_STATUS_402';
    public const statusBlocked = 'VI_STATUS_423';
    public const statusNotDetermined = 'VI_STATUS_OTHER';

}