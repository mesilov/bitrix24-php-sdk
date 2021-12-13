<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

/**
 * Class Result
 *
 * @package Bitrix24\SDK\Core\Response\DTO
 */
class Result
{
    protected array $result;

    /**
     * Result constructor.
     *
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getResultData(): array
    {
        return $this->result;
    }
}