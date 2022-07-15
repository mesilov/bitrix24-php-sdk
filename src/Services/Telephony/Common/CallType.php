<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class CallType
{

    private const outboundCall = '1';
    private const inboundCall = '2';
    private const inboundCallWithRedirection = '3';
    private const backCall = '4';
    private string $code;

    /**
     * @param string $typeCode
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */

    private function __construct(string $typeCode)
    {
        switch ($typeCode) {
            case $this::inboundCall:
            case $this::outboundCall:
            case $this::inboundCallWithRedirection:
            case $this::backCall:
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
     * @return string
     */

    public static function backCall(): string
    {
        return self::backCall;
    }

    public function __toString(): string
    {
        return $this->code;
    }

}

