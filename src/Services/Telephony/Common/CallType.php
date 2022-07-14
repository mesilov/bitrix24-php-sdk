<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class CallType
{
    private const one = 1;
    private const two = 2;
    private const three = 3;
    private const four = 4;
    private int $code;

    /**
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct($typeCall)
    {
        switch ($typeCall) {
            case $this::one:
            case $this::two:
            case $this::three:
            case $this::four:
                $this->code = $typeCall ;
                break;
            default:
                throw new InvalidArgumentException(sprintf('unknown type call %s', $typeCall));
        }
    }

    /**
     * @return self
     */
    public static function one(): self
    {
        return new self(self::one);
    }

    /**
     * @return self
     */
    public static function two(): self
    {
        return new self(self::two);
    }

    /**
     * @return self
     */
    public static function three(): self
    {
        return new self(self::three);
    }

    /**
     * @return self
     */
    public static function four(): self
    {
        return new self(self::four);
    }


}

