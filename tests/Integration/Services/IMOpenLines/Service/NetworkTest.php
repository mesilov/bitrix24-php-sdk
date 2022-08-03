<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\IMOpenLines\Service;

use Bitrix24\SDK\Services\IMOpenLines\Service\Network;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class NetworkTest extends TestCase
{
    private Network $networkService;

    /**
     * @covers  \Bitrix24\SDK\Services\IMOpenLines\Service\Network::join
     * @testdox test get agreements list
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testJoin(): void
    {
        $res = $this->networkService->join(Fabric::getOpenLineCode());
        $this->assertGreaterThanOrEqual(1, $res->getId());
    }

    /**
     * @covers  \Bitrix24\SDK\Services\IMOpenLines\Service\Network::join
     * @testdox test get agreements list
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testMessageAdd(): void
    {
        $res = $this->networkService->messageAdd(
            Fabric::getOpenLineCode(),
            (int)$this->networkService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message at %s', time())
        );

        $this->assertTrue($res->isSuccess());
    }

    public function setUp(): void
    {
        $this->networkService = Fabric::getServiceBuilder()->getIMOpenLinesScope()->Network();
    }
}