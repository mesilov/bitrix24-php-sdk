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

    public function testFree(): void
    {
        $this->assertTrue(ApplicationStatus::free()->isFree());
    }

    public function testDemo(): void
    {
        $this->assertTrue(ApplicationStatus::demo()->isDemo());
    }

    public function testTrial(): void
    {
        $this->assertTrue(ApplicationStatus::trial()->isTrial());
    }

    public function testPaid(): void
    {
        $this->assertTrue(ApplicationStatus::paid()->isPaid());
    }

    public function testLocal(): void
    {
        $this->assertTrue(ApplicationStatus::local()->isLocal());
    }

    public function testSubscription(): void
    {
        $this->assertTrue(ApplicationStatus::subscription()->isLocal());
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