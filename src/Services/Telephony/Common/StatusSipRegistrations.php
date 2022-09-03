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

class StatusSipRegistrations
{
    private const SUCCESS = 'success';
    private const ERROR = 'error';
    private const IN_PROGRESS = 'in_progress';
    private const WAIT = 'wait';
    private string $code;

    /**
     * @param string $typeSip
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct(string $typeSip)
    {
        switch ($typeSip) {
            case $this::SUCCESS:
            case $this::ERROR:
            case $this::IN_PROGRESS:
            case $this::WAIT:
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
        return new self(self::SUCCESS);
    }

    /**
     * @return self
     */
    public static function error(): self
    {
        return new self(self::ERROR);
    }

    /**
     * @return self
     */
    public static function in_progress(): self
    {
        return new self(self::IN_PROGRESS);
    }

    /**
     * @return self
     */
    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }
}