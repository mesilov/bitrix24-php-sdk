<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Core\Response\DTO;

use Bitrix24\SDK\Core\Response\DTO\Time;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeTest
 *
 * @package Bitrix24\SDK\Tests\Unit\Core\Response\DTO
 */
class TimeTest extends TestCase
{
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public function testInitFromResponseData(): void
    {
        $result = [
            'start'       => 1604098405.469694,
            'finish'      => 1604098405.50439,
            'duration'    => 0.034696102142333984,
            'processing'  => 6.198883056640625E-5,
            'date_start'  => '2020-10-31T01:53:25+03:00',
            'date_finish' => '2020-10-31T01:53:26+03:00',
        ];

        $time = Time::initFromResponse($result);

        $this->assertEquals($result['start'], $time->getStart());
        $this->assertEquals($result['finish'], $time->getFinish());
        $this->assertEquals($result['duration'], $time->getDuration());
        $this->assertEquals($result['processing'], $time->getProcessing());
        $this->assertEquals($result['date_start'], $time->getDateStart()->format(\DATE_ATOM));
        $this->assertEquals($result['date_finish'], $time->getDateFinish()->format(\DATE_ATOM));
    }
}
