<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

use DateTimeImmutable;
use Exception;

readonly class Time
{
    public function __construct(
        private float             $start,
        private float             $finish,
        private float             $duration,
        private float             $processing,
        /**
         * @see https://training.bitrix24.com/rest_help/rest_sum/operating.php
         */
        private float             $operating,
        private DateTimeImmutable $dateStart,
        private DateTimeImmutable $dateFinish,
        /**
         * @see https://training.bitrix24.com/rest_help/rest_sum/operating.php
         */
        private ?int              $operatingResetAt
    )
    {
    }

    public function getStart(): float
    {
        return $this->start;
    }

    public function getFinish(): float
    {
        return $this->finish;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function getProcessing(): float
    {
        return $this->processing;
    }

    public function getOperating(): float
    {
        return $this->operating;
    }

    public function getOperatingResetAt(): ?int
    {
        return $this->operatingResetAt;
    }

    public function getDateStart(): DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function getDateFinish(): DateTimeImmutable
    {
        return $this->dateFinish;
    }

    /**
     * @throws Exception
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