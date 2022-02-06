<?php

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
class WebhookUrlTest extends TestCase
{
    /**
     * @return void
     * @covers  \Bitrix24\SDK\Core\Credentials\WebhookUrl
     * @testdox Test valid webhook url
     */
    public function testValidWebhookUrl(): void
    {
        $wh = new WebhookUrl('https://bitrix24.ru/');
        $this->assertTrue(true);
    }

    /**
     * @return void
     * @testdox Test invalid webhook url
     * @covers  \Bitrix24\SDK\Core\Credentials\WebhookUrl
     */
    public function testInvalidWebhookUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $wh = new WebhookUrl('qqqq');
    }
}
