<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

class CrmEntityType
{
    private const contact = 'CONTACT';
    private const company = 'COMPANY';
    private const lead = 'LEAD';
    private string $code;

    /**
     * @param string $typeCode
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    private function __construct(string $typeCode)
    {
        switch ($typeCode) {
            case $this::company:
            case $this::contact:
            case $this::lead:
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
        return new self(self::contact);
    }

    /**
     * @return self
     */
    public static function company(): self
    {
        return new self(self::company);
    }

    /**
     * @return self
     */
    public static function lead(): self
    {
        return new self(self::lead);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }
}