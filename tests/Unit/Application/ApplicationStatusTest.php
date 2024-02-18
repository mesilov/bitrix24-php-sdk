<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Generator;
use PHPUnit\Framework\TestCase;

class ApplicationStatusTest extends TestCase
{
    /**
     * @param string $shortCode
     * @param string $longCode
     *
     * @return void
     * @dataProvider statusDataProvider
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function testGetStatusCode(string $shortCode, string $longCode): void
    {
        $this->assertEquals(
            $longCode,
            (new ApplicationStatus($shortCode))->getStatusCode()
        );
    }

    /**
     * @return void
     */
    public function testInvalidStatusCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ApplicationStatus('foo');
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @covers \Bitrix24\SDK\Application\ApplicationStatus::initFromString
     */
    public function testInitFromString(): void
    {
        $this->assertTrue(ApplicationStatus::initFromString('F')->isFree());
    }

    /**
     * @return \Generator
     */
    public static function statusDataProvider(): Generator
    {
        yield 'free' => [
            'F',
            'free',
        ];

        yield 'demo' => [
            'D',
            'demo',
        ];
        yield 'trial' => [
            'T',
            'trial',
        ];
        yield 'paid' => [
            'P',
            'paid',
        ];
        yield 'local' => [
            'L',
            'local',
        ];
        yield 'subscription' => [
            'S',
            'subscription',
        ];
    }
}