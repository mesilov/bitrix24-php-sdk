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

namespace Bitrix24\SDK\Tests\Unit\Core\Response\DTO;

use Bitrix24\SDK\Core\Response\DTO\Time;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeTest
 *
 * @package Bitrix24\SDK\Tests\Unit\Core\Response\DTO
 */
class TimeTest extends TestCase
{
    /**
     * @throws \Exception
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('timingsDataProvider')]
    public function testInitFromResponseData(array $result): void
    {
        $time = Time::initFromResponse($result);

        $this->assertEquals($result['start'], $time->start);
        $this->assertEquals($result['finish'], $time->finish);
        $this->assertEquals($result['duration'], $time->duration);
        $this->assertEquals($result['processing'], $time->processing);
        $this->assertEquals($result['operating'], $time->operating);
        $this->assertEquals($result['operating_reset_at'], $time->operatingResetAt);
        $this->assertEquals($result['date_start'], $time->dateStart->format(\DATE_ATOM));
        $this->assertEquals($result['date_finish'], $time->dateFinish->format(\DATE_ATOM));
    }

    public static function timingsDataProvider(): Generator
    {
        yield 'without operating reset at' => [
            [
                'start'              => 1604098405.469694,
                'finish'             => 1604098405.50439,
                'duration'           => 0.034696102142333984,
                'processing'         => 6.198883056640625E-5,
                'operating'          => 0.11336898803710938,
                'operating_reset_at' => null,
                'date_start'         => '2020-10-31T01:53:25+03:00',
                'date_finish'        => '2020-10-31T01:53:26+03:00',
            ],
        ];

        yield 'with operating reset at' => [
            [
                'start'              => 1604098405.469694,
                'finish'             => 1604098405.50439,
                'duration'           => 0.034696102142333984,
                'processing'         => 6.198883056640625E-5,
                'operating'          => 0.11336898803710938,
                'operating_reset_at' => 20,
                'date_start'         => '2020-10-31T01:53:25+03:00',
                'date_finish'        => '2020-10-31T01:53:26+03:00',
            ],
        ];
    }
}
