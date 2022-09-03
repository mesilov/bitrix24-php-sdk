<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

/**
 * Class ResponseData
 *
 * @package Bitrix24\SDK\Core\Response\DTO
 */
class ResponseData
{
    protected array $result;
    protected Time $time;
    protected Pagination $pagination;

    /**
     * ResponseData constructor.
     *
     * @param array      $result
     * @param Time       $time
     * @param Pagination $pagination
     */
    public function __construct(array $result, Time $time, Pagination $pagination)
    {
        $this->result = $result;
        $this->time = $time;
        $this->pagination = $pagination;
    }

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * @return Time
     */
    public function getTime(): Time
    {
        return $this->time;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}