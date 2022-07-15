<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class CallType
{
    private const OUTBOUND_CALL = 1;
    private const INBOUND_CALL = 2;
    private const INBOUND_CALL_WITH_REDIRECTION = 3;
    private const CALLBACK = 4;
    private int $code;

    /**
     * @param int $typeCode
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */

    private function __construct(int $typeCode)
    {
        switch ($typeCode) {
            case $this::INBOUND_CALL:
            case $this::OUTBOUND_CALL:
            case $this::INBOUND_CALL_WITH_REDIRECTION:
            case $this::CALLBACK:
                $this->code = $typeCode;
                break;
            default:
                throw new InvalidArgumentException(sprintf('unknown type call %s', $typeCode));
        }
    }

    /**
     * @return string
     */

    public static function outboundCall(): string
    {
        return self::outboundCall;
    }

    /**
     * @return string
     */

    public static function inboundCall(): string
    {
        return self::inboundCall;
    }

    /**
     * @return string
     */

    public static function inboundCallWithRedirection(): string
    {
        return self::inboundCallWithRedirection;
    }

    /**
     * @return self
     */

    public static function backCall(): string
    {
        return new self( self::CALLBACK);
    }

    public function __toString(): string
    {
        return (string)$this->code;
    }

}

