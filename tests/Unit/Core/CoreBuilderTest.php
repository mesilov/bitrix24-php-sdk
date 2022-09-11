<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Core;

use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use PHPUnit\Framework\TestCase;

class CoreBuilderTest extends TestCase
{
    /**
     * @throws UnknownScopeCodeException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function testBuildWithCredentialsFromWebhook(): void
    {
        $core = (new CoreBuilder())
            ->withCredentials(Credentials::createFromWebhook(new WebhookUrl('https://127.0.0.1')))
            ->build();
        // successful build core
        $this->assertTrue(true);
    }

    /**
     * @throws UnknownScopeCodeException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function testBuildWithoutCredentials(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $core = (new CoreBuilder())
            ->build();
    }
}
