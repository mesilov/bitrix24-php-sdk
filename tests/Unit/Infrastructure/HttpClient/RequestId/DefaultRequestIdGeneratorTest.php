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

namespace Bitrix24\SDK\Tests\Unit\Infrastructure\HttpClient\RequestId;

use Bitrix24\SDK\Infrastructure\HttpClient\RequestId\DefaultRequestIdGenerator;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Infrastructure\HttpClient\RequestId\DefaultRequestIdGenerator::class)]
class DefaultRequestIdGeneratorTest extends TestCase
{
    /**
     * @param $requestIdKey
     * @param $requestId
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('requestIdKeyDataProvider')]
    public function testExistsRequestId(string $requestIdKey, string $requestId): void
    {
        $_SERVER[$requestIdKey] = $requestId;
        $defaultRequestIdGenerator = new DefaultRequestIdGenerator();
        $this->assertEquals($requestId, $defaultRequestIdGenerator->getRequestId());
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
