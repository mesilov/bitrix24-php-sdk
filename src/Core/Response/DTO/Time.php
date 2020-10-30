<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

/**
 * Class Time
 *
 * @package Bitrix24\SDK\Core\Response\DTO
 */
class Time
{
    /**
     * @var float
     */
    protected $start;
    /**
     * @var float
     */
    protected $finish;
    /**
     * @var float
     */
    protected $duration;
    /**
     * @var float
     */
    protected $processing;
    /**
     * @var \DateTimeImmutable
     */
    protected $dateStart;
    /**
     * @var \DateTimeImmutable
     */
    protected $dateFinish;

    /**
     * Time constructor.
     *
     * @param float              $start
     * @param float              $finish
     * @param float              $duration
     * @param float              $processing
     * @param \DateTimeImmutable $dateStart
     * @param \DateTimeImmutable $dateFinish
     */
    public function __construct(
        float $start,
        float $finish,
        float $duration,
        float $processing,
        \DateTimeImmutable $dateStart,
        \DateTimeImmutable $dateFinish
    ) {
        $this->start = $start;
        $this->finish = $finish;
        $this->duration = $duration;
        $this->processing = $processing;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
    }

    /**
     * @return float
     */
    public function getStart(): float
    {
        return $this->start;
    }

    /**
     * @return float
     */
    public function getFinish(): float
    {
        return $this->finish;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @return float
     */
    public function getProcessing(): float
    {
        return $this->processing;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateStart(): \DateTimeImmutable
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateFinish(): \DateTimeImmutable
    {
        return $this->dateFinish;
    }

    /**
     * @param array $response
     *
     * @return static
     * @throws \Exception
     */
    public static function initFromResponse(array $response): self
    {
        return new self(
            (float)$response['start'],
            (float)$response['finish'],
            (float)$response['duration'],
            (float)$response['processing'],
            new \DateTimeImmutable($response['date_start']),
            new \DateTimeImmutable($response['date_finish'])
        );
    }
}