<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

use Bitrix24\SDK\Core\Commands\Command;

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
    protected Command $command;

    /**
     * ResponseData constructor.
     *
     * @param Result                              $result
     * @param Time                                $time
     * @param Pagination                          $pagination
     * @param \Bitrix24\SDK\Core\Commands\Command $command
     */
    public function __construct(Result $result, Time $time, Pagination $pagination, Command $command)
    {
        $this->result = $result;
        $this->time = $time;
        $this->pagination = $pagination;
        $this->command = $command;
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

    /**
     * @return \Bitrix24\SDK\Core\Commands\Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }
}