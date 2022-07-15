<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class CallType
{

    public const one = 1;
    public const two = 2;
    public const three = 3;
    public const four = 4;

    private int $code;

    /**
     * @param int $code
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */

    private function __construct(int $code)
    {
        if
        (
            self::one !== $code &&
            self::two !== $code &&
            self::three !== $code &&
            self::four !== $code
        ) {
            throw new InvalidArgumentException(sprintf('unknown type call %s', $code));
        }
        $this->code = $code;

    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->code;
    }
}

