<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Exceptions;

use Throwable;

class MethodConfirmWaitingException extends BaseException
{
    public readonly string $methodName;

    public function __construct(string $methodName, string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->methodName = $methodName;
    }
}