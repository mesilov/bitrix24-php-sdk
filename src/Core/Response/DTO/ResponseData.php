<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

class ResponseData
{
    /**
     * ResponseData constructor.
     */
    public function __construct(
        protected array               $result,
        readonly protected Time       $time,
        readonly protected Pagination $pagination)
    {
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    public function getTime(): Time
    {
        return $this->time;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}