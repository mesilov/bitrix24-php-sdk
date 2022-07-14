<?php

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class TypeAtc
{
    private const cloudAtc = 'cloud';
    private const officeAtc = 'office';
    private string $code;

    /**
     * @param string $typeAtc
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct(string $typeAtc)
    {
        switch ($typeAtc) {
            case $this::cloudAtc:
            case $this::officeAtc:
                $this->code = $typeAtc;
                break;
            default:
                throw new InvalidArgumentException(sprintf('unknown type ATC %s', $typeAtc));
        }
    }

    /**
     * @return self
     */
    public static function cloud(): self
    {
        return new self(self::cloudAtc);
    }

    /**
     * @return self
     */
    public static function office(): self
    {
        return new self(self::officeAtc);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }
}