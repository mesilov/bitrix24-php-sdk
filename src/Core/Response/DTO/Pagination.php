<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

/**
 * Class Pagination
 *
 * @package Bitrix24\SDK\Core\Response\DTO
 */
class Pagination
{
    /**
     * @var int|null
     */
    private $nextPage;
    /**
     * @var int|null
     */
    private $total;

    /**
     * Pagination constructor.
     *
     * @param int|null $nextPage
     * @param int|null $total
     */
    public function __construct(int $nextPage = null, int $total = null)
    {
        $this->nextPage = $nextPage;
        $this->total = $total;
    }

    /**
     * @return int|null
     */
    public function getNextPage(): ?int
    {
        return $this->nextPage;
    }

    /**
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }
}