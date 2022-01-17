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
    protected Result $result;
    protected Time $time;
    protected Pagination $pagination;

    /**
     * ResponseData constructor.
     *
     * @param Result     $result
     * @param Time       $time
     * @param Pagination $pagination
     */
    public function __construct(Result $result, Time $time, Pagination $pagination)
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
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->result;
    }
}