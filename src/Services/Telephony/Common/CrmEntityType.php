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

class CrmEntityType
{
    private const CONTACT = 'CONTACT';
    private const COMPANY = 'COMPANY';
    private const LEAD = 'LEAD';
    private string $code;

    /**
     * @param string $typeCode
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct(string $typeCode)
    {
        switch ($typeCode) {
            case $this::COMPANY:
            case $this::CONTACT:
            case $this::LEAD:
                $this->code = $typeCode;
                break;
            default:
                throw new InvalidArgumentException(sprintf('unknown crm entity type code %s', $typeCode));
        }
    }

    /**
     * @return self
     */
    public static function contact(): self
    {
        return new self(self::CONTACT);
    }

    /**
     * @return bool
     */
    public function isContact(): bool
    {
        return $this->code === $this::CONTACT;
    }

    /**
     * @return self
     */
    public static function company(): self
    {
        return new self(self::COMPANY);
    }

    /**
     * @return bool
     */
    public function isCompany(): bool
    {
        return $this->code === $this::COMPANY;
    }

    /**
     * @return self
     */
    public static function lead(): self
    {
        return new self(self::LEAD);
    }

    /**
     * @return bool
     */
    public function isLead(): bool
    {
        return $this->code === $this::LEAD;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public static function initByCode(string $entityTypeCode): self
    {
        return new self($entityTypeCode);
    }
}