<?php

declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     *
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
     * @return self
     */
    public static function outboundCall(): self
    {
        return new self(self::OUTBOUND_CALL);
    }

    /**
     * @return bool
     */
    public function isOutboundCall(): bool
    {
        return $this->code === self::OUTBOUND_CALL;
    }

    /**
     * @return self
     */
    public static function inboundCall(): self
    {
        return new self(self::INBOUND_CALL);
    }

    /**
     * @return bool
     */
    public function isInboundCall(): bool
    {
        return $this->code === self::INBOUND_CALL;
    }

    /**
     * @return self
     */
    public static function inboundCallWithRedirection(): self
    {
        return new self(self::INBOUND_CALL_WITH_REDIRECTION);
    }

    /**
     * @return bool
     */
    public function isInboundCallWithRedirection(): bool
    {
        return $this->code === self::INBOUND_CALL_WITH_REDIRECTION;
    }

    /**
     * @return self
     */
    public static function callback(): self
    {
        return new self(self::CALLBACK);
    }

    /**
     * @return bool
     */
    public function isCallback(): bool
    {
        return $this->code === self::CALLBACK;
    }

    public function __toString(): string
    {
        return (string)$this->code;
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function initByTypeCode(int $callTypeCode): self
    {
        return new self($callTypeCode);
    }
}

