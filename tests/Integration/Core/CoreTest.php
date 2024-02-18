<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Core;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\AuthForbiddenException;
use Bitrix24\SDK\Core\Exceptions\MethodNotFoundException;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class CoreTest extends TestCase
{
    protected CoreInterface $core;
    protected LoggerInterface $log;
    protected Stopwatch $stopwatch;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testCallExistingApiMethod(): void
    {
        $response = $this->core->call('app.info');
        $this->assertIsArray($response->getResponseData()->getResult());
    }

    public function testConnectToNonExistsBitrix24PortalInCloud():void
    {
        $core = (new CoreBuilder())
        ->withCredentials(Credentials::createFromOAuth(
            new AccessToken('non-exists-access-token','refresh-token', 3600),
            new ApplicationProfile('non-exists-client-id', 'non-exists-client-secret', new Scope([])),
            'non-exists-domain.bitrix24.com'
        ))
        ->build();
        $this->expectException(AuthForbiddenException::class);
        $core->call('app.info');
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testCallUnknownApiMethod(): void
    {
        $this->expectException(MethodNotFoundException::class);
        $response = $this->core->call('unknownMethod');
    }

    public function setUp(): void
    {
        $this->core = Fabric::getCore();
        $this->stopwatch = new Stopwatch(true);
        $this->log = Fabric::getLogger();
    }
}