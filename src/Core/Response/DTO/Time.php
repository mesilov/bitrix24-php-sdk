<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response\DTO;

use Carbon\CarbonImmutable;
use Exception;

readonly class Time
{
    public function __construct(
        public float           $start,
        public float           $finish,
        public float           $duration,
        public float           $processing,
        /**
         * @see https://training.bitrix24.com/rest_help/rest_sum/operating.php
         */
        public float           $operating,
        public CarbonImmutable $dateStart,
        public CarbonImmutable $dateFinish,
        /**
         * @see https://training.bitrix24.com/rest_help/rest_sum/operating.php
         */
        public ?int            $operatingResetAt
    )
    {
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
            new CarbonImmutable($response['date_start']),
            new CarbonImmutable($response['date_finish']),
            $response['operating_reset_at'] ?? null
        );
    }
}