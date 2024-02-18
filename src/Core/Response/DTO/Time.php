<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

use DateTimeImmutable;

/**
 * Class Time
 *
 * @package Bitrix24\SDK\Core\Response\DTO
 */
class Time
{
    private float $start;
    private float $finish;
    private float $duration;
    private float $processing;
    /**
     * @var float $operating sum of query execution time
     * @see https://training.bitrix24.com/rest_help/rest_sum/operating.php
     */
    private float $operating; // time in seconds
    private DateTimeImmutable $dateStart;
    private DateTimeImmutable $dateFinish;
    /**
     * @var int|null time to reset nearest limit part
     * @see https://training.bitrix24.com/rest_help/rest_sum/operating.php
     */
    private ?int $operatingResetAt;

    /**
     * Time constructor.
     *
     * @param float $start
     * @param float $finish
     * @param float $duration
     * @param float $processing
     * @param float $operating
     * @param \DateTimeImmutable $dateStart
     * @param \DateTimeImmutable $dateFinish
     * @param int|null $operatingResetAt
     */
    public function __construct(
        float             $start,
        float             $finish,
        float             $duration,
        float             $processing,
        float             $operating,
        DateTimeImmutable $dateStart,
        DateTimeImmutable $dateFinish,
        ?int              $operatingResetAt
    )
    {
        $this->start = $start;
        $this->finish = $finish;
        $this->duration = $duration;
        $this->processing = $processing;
        $this->operating = $operating;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
        $this->operatingResetAt = $operatingResetAt;
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
     * @return float
     */
    public function getOperating(): float
    {
        return $this->operating;
    }

    /**
     * @return int|null
     */
    public function getOperatingResetAt(): ?int
    {
        return $this->operatingResetAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateStart(): DateTimeImmutable
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateFinish(): DateTimeImmutable
    {
        return $this->dateFinish;
    }

    /**
     * @param array $response
     *
     * @return self
     * @throws \Exception
     */
    public static function initFromResponse(array $response): self
    {
        return new self(
            (float)$response['start'],
            (float)$response['finish'],
            (float)$response['duration'],
            (float)$response['processing'],
            array_key_exists('operating', $response) ? (float)$response['operating'] : 0,
            new DateTimeImmutable($response['date_start']),
            new DateTimeImmutable($response['date_finish']),
            $response['operating_reset_at'] ?? null
        );
    }
}