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

class TypeAtc
{
    private const CLOUD = 'cloud';
    private const OFFICE = 'office';
    private string $code;

    /**
     * @param string $typeAtc
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct(string $typeAtc)
    {
        switch ($typeAtc) {
            case $this::CLOUD:
            case $this::OFFICE:
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
        return new self(self::CLOUD);
    }

    /**
     * @return self
     */
    public static function office(): self
    {
        return new self(self::OFFICE);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }
}