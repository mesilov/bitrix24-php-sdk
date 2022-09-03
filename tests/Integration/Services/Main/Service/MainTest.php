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
     * @covers \Bitrix24\SDK\Services\Main\Service\Main::getServerTime
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testGetServerTime(): void
    {
        $this->mainService->getServerTime()->time();
        $this->assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\Main\Service\Main::getCurrentUserProfile
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testGetCurrentUserProfile(): void
    {
        $profile = $this->mainService->getCurrentUserProfile()->getUserProfile();
        $this->assertTrue($profile->ADMIN);
    }

    /**
     * @covers \Bitrix24\SDK\Services\Main\Service\Main::isCurrentUserHasAdminRights
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testIsUserIsAdmin(): void
    {
        $this->assertTrue($this->mainService->isCurrentUserHasAdminRights()->isAdmin());
    }

    /**
     * @covers \Bitrix24\SDK\Services\Main\Service\Main::getMethodAffordability
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testMethodGetInformationForNonExistsMethod(): void
    {
        $this->assertFalse($this->mainService->getMethodAffordability('app.info1')->isAvailable());
        $this->assertFalse($this->mainService->getMethodAffordability('app.info1')->isExisting());
    }

    /**
     * @covers \Bitrix24\SDK\Services\Main\Service\Main::getApplicationInfo
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testApplicationInfo(): void
    {
        $this->assertIsString($this->mainService->getApplicationInfo()->applicationInfo()->LICENSE);
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public function testGetAvailableScope(): void
    {
        $scope = new Scope($this->mainService->getAvailableScope()->getResponseData()->getResult());
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
            count((new Scope($this->mainService->getCurrentScope()->getResponseData()->getResult()))->getScopeCodes()),
            count((new Scope($this->mainService->getAvailableScope()->getResponseData()->getResult()))->getScopeCodes())
        );
    }

    /**
     * @covers  \Bitrix24\SDK\Services\Main\Service\Main::getAvailableMethods
     * @testdox test methods list
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testGetAvailableMethods(): void
    {
        $this->assertIsArray($this->mainService->getAvailableMethods()->getResponseData()->getResult());
    }

    public function setUp(): void
    {
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
    }
}