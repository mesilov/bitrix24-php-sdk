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

namespace Bitrix24\SDK\Tests\Unit\Core\Credentials;

use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Generator;
use PHPUnit\Framework\TestCase;

class ApplicationProfileTest extends TestCase
{
    /**
     *
     *
     * @throws InvalidArgumentException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('arrayDataProvider')]
    public function testFromArray(array $arr, ?string $expectedException): void
    {
        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $applicationProfile = ApplicationProfile::initFromArray($arr);

        $this->assertEquals($applicationProfile->getClientId(), $arr['BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID']);
        $this->assertEquals($applicationProfile->getClientSecret(), $arr['BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET']);
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
