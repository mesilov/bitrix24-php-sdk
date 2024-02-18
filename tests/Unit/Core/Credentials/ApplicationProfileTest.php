<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Core\Credentials;

use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Generator;
use PHPUnit\Framework\TestCase;

class ApplicationProfileTest extends TestCase
{
    /**
     *
     * @param array $arr
     * @param string|null $expectedException
     *
     * @return void
     * @throws InvalidArgumentException
     * @dataProvider arrayDataProvider
     */
    public function testFromArray(array $arr, ?string $expectedException): void
    {
        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }
        $prof = ApplicationProfile::initFromArray($arr);

        $this->assertEquals($prof->getClientId(), $arr['BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID']);
        $this->assertEquals($prof->getClientSecret(), $arr['BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET']);
    }

    public static function arrayDataProvider(): Generator
    {
        yield 'valid' => [
            [
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => '1',
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => '2',
                'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => 'user',
            ],
            null,
        ];
        yield 'without client id' => [
            [
                '' => '1',
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => '2',
                'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => 'user',
            ],
            InvalidArgumentException::class,
        ];
        yield 'without client secret' => [
            [
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => '1',
                '' => '2',
                'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => 'user',
            ],
            InvalidArgumentException::class,
        ];
        yield 'without client application scope' => [
            [
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => '1',
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => '2',
                '' => 'user',
            ],
            InvalidArgumentException::class,
        ];
        yield 'with empty scope' => [
            [
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => '1',
                'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => '2',
                'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => '',
            ],
            null
        ];
    }
}
