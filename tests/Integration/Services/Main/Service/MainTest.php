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

namespace Bitrix24\SDK\Tests\Integration\Services\Main\Service;

use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Main::class)]
class MainTest extends TestCase
{
    private Main $mainService;

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testGetServerTime(): void
    {
        $this->mainService->getServerTime()->time();
        $this->assertTrue(true);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testGetCurrentUserProfile(): void
    {
        $userProfileItemResult = $this->mainService->getCurrentUserProfile()->getUserProfile();
        $this->assertTrue($userProfileItemResult->ADMIN);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testIsUserIsAdmin(): void
    {
        $this->assertTrue($this->mainService->isCurrentUserHasAdminRights()->isAdmin());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testMethodGetInformationForNonExistsMethod(): void
    {
        $this->assertFalse($this->mainService->getMethodAffordability('app.info1')->isAvailable());
        $this->assertFalse($this->mainService->getMethodAffordability('app.info1')->isExisting());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testApplicationInfo(): void
    {
        $this->assertIsString($this->mainService->getApplicationInfo()->applicationInfo()->LICENSE);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws UnknownScopeCodeException
     */
    public function testGetAvailableScope(): void
    {
        $scope = new Scope($this->mainService->getAvailableScope()->getResponseData()->getResult());
        $this->assertIsArray($scope->getScopeCodes());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws UnknownScopeCodeException
     */
    public function testGetCurrentScope(): void
    {
        $this->assertGreaterThanOrEqual(
            count((new Scope($this->mainService->getCurrentScope()->getResponseData()->getResult()))->getScopeCodes()),
            count((new Scope($this->mainService->getAvailableScope()->getResponseData()->getResult()))->getScopeCodes())
        );
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test methods list')]
    public function testGetAvailableMethods(): void
    {
        $this->assertIsArray($this->mainService->getAvailableMethods()->getResponseData()->getResult());
    }

    protected function setUp(): void
    {
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
    }
}