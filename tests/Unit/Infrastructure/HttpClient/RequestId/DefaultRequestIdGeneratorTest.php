<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Infrastructure\HttpClient\RequestId;

use Bitrix24\SDK\Infrastructure\HttpClient\RequestId\DefaultRequestIdGenerator;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DefaultRequestIdGeneratorTest extends TestCase
{
    /**
     * @param $requestIdKey
     * @param $requestId
     * @return void
     * @dataProvider requestIdKeyDataProvider
     * @covers \Bitrix24\SDK\Infrastructure\HttpClient\RequestId\DefaultRequestIdGenerator::getRequestId
     */
    public function testExistsRequestId($requestIdKey, $requestId): void
    {
        $_SERVER[$requestIdKey] = $requestId;
        $gen = new DefaultRequestIdGenerator();
        $this->assertEquals($requestId, $gen->getRequestId());
        unset($_SERVER[$requestIdKey]);
    }

    public static function requestIdKeyDataProvider(): Generator
    {
        yield 'REQUEST_ID' => [
            'REQUEST_ID',
            Uuid::v7()->toRfc4122()
        ];
        yield 'HTTP_X_REQUEST_ID' => [
            'HTTP_X_REQUEST_ID',
            Uuid::v7()->toRfc4122()
        ];
        yield 'UNIQUE_ID' => [
            'UNIQUE_ID',
            Uuid::v7()->toRfc4122()
        ];
    }
}
