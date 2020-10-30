<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

/**
 * Class Response
 *
 * @package Bitrix24\SDK\Core\Response\DTO
 */
class Response
{
    /**
     * @var Result
     */
    protected $result;
    /**
     * @var Time
     */
    protected $time;

    /**
     * Response constructor.
     *
     * @param Result $result
     * @param Time   $time
     */
    public function __construct(Result $result, Time $time)
    {
        $this->result = $result;
        $this->time = $time;
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