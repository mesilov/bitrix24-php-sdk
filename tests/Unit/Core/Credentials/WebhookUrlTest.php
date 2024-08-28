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

use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class ScopeTest
 *
 * @package Bitrix24\SDK\Tests\Unit\Core
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Core\Credentials\WebhookUrl::class)]
class WebhookUrlTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\TestDox('Test valid webhook url')]
    public function testValidWebhookUrl(): void
    {
        new WebhookUrl('https://bitrix24.ru/');
        $this->assertTrue(true);
    }

    #[\PHPUnit\Framework\Attributes\TestDox('Test invalid webhook url')]
    public function testInvalidWebhookUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new WebhookUrl('qqqq');
    }
}
