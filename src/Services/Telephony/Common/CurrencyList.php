<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class CurrencyList
{
    private const RUB = 'RUB';
    private const USD = 'USD';
    private const EUR = 'EUR';
    private const UAH = 'UAH';
    private const BYN = 'BYN';
    private string $code;

    /**
     * @param string $typeCode
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct(string $typeCode)
    {
        switch ($typeCode) {
            case $this::RUB:
            case $this::USD:
            case $this::EUR:
            case $this::UAH:
            case $this::BYN:
                $this->code = $typeCode;
                break;
            default:
                throw new InvalidArgumentException(sprintf('unknown currency %s', $typeCode));
        }
    }

    /**
     * @return self
     */
    public static function rub(): self
    {
        return new self(self::RUB);
    }

    /**
     * @return self
     */
    public static function usd(): self
    {
        return new self(self::USD);
    }

    /**
     * @return self
     */
    public static function eur(): self
    {
        return new self(self::EUR);
    }

    /**
     * @return self
     */
    public static function uah(): self
    {
        return new self(self::UAH);
    }

    /**
     * @return self
     */
    public static function byn(): self
    {
        return new self(self::BYN);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }


}