<?php

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
     * @dataProvider timingsDataProvider
     */
    public function testInitFromResponseData(array $result): void
    {
        $time = Time::initFromResponse($result);

        $this->assertEquals($result['start'], $time->getStart());
        $this->assertEquals($result['finish'], $time->getFinish());
        $this->assertEquals($result['duration'], $time->getDuration());
        $this->assertEquals($result['processing'], $time->getProcessing());
        $this->assertEquals($result['operating'], $time->getOperating());
        $this->assertEquals($result['operating_reset_at'], $time->getOperatingResetAt());
        $this->assertEquals($result['date_start'], $time->getDateStart()->format(\DATE_ATOM));
        $this->assertEquals($result['date_finish'], $time->getDateFinish()->format(\DATE_ATOM));
    }

    /**
     * @return \Generator
     */
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
