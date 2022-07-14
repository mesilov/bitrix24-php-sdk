<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class StatusSipRegistrations
{
    private const success = 'success';
    private const error = 'error';
    private const in_progress = 'in_progress';
    private const wait = 'wait';
    private string $code;

    /**
     * @param string $typeSip
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct(string $typeSip)
    {
        switch ($typeSip) {
            case $this::success:
            case $this::error:
            case $this::in_progress:
            case $this::wait:
                $this->code = $typeSip;
                break;
            default:
                throw new InvalidArgumentException(sprintf('unknown status SIP registrations %s', $typeSip));
        }
    }

    /**
     * @return self
     */
    public static function success(): self
    {
        return new self(self::success);
    }

    /**
     * @return self
     */
    public static function error(): self
    {
        return new self(self::error);
    }

    /**
     * @return self
     */
    public static function in_progress(): self
    {
        return new self(self::in_progress);
    }

    /**
     * @return self
     */
    public static function wait(): self
    {
        return new self(self::wait);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }
}