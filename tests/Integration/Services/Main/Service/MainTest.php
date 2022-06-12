<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Main\Service;

use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    private Main $mainService;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public function testGetAvailableScope(): void
    {
        $scope = new Scope($this->mainService->getAvailableScope()->getResponseData()->getResult()->getResultData());
        $this->assertIsArray($scope->getScopeCodes());
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public function testGetCurrentScope(): void
    {
        $this->assertGreaterThanOrEqual(
            count((new Scope($this->mainService->getCurrentScope()->getResponseData()->getResult()->getResultData()))->getScopeCodes()),
            count((new Scope($this->mainService->getAvailableScope()->getResponseData()->getResult()->getResultData()))->getScopeCodes())
        );
    }

    /**
     * @covers  Bitrix24\SDK\Services\Main\Service\Main::getAvailableMethods
     * @testdox test methods list
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testList(): void
    {
        $this->assertIsArray($this->mainService->getAvailableMethods()->getResponseData()->getResult()->getResultData());
    }

    public function setUp(): void
    {
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
    }
}