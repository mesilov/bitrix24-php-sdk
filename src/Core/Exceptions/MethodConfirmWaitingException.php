<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Exceptions;

use Throwable;

class MethodConfirmWaitingException extends BaseException
{
    public function __construct(public readonly string $methodName, string $message, int $code = 0, ?Throwable $throwable = null)
    {
        parent::__construct($message, $code, $throwable);
    }
}