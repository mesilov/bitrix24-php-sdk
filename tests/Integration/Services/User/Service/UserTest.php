<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\User\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\User\Result\UserItemResult;
use Bitrix24\SDK\Services\User\Service\User;
use Bitrix24\SDK\Services\UserConsent\Service\UserConsent;
use Bitrix24\SDK\Services\UserConsent\Service\UserConsentAgreement;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $userService;

    /**
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers  \Bitrix24\SDK\Services\User\Service\User::get
     * @testdox test get users with filter
     */
    public function testUserSearch(): void
    {
        $users = $this->userService->search([
            'NAME' => 'test',
        ]);
        $this->assertGreaterThanOrEqual(1, $users->getCoreResponse()->getResponseData()->getPagination()->getTotal());
    }

    /**
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers  \Bitrix24\SDK\Services\User\Service\User::get
     * @testdox test get users list with internal phone
     */
    public function testGetWithInternalPhone(): void
    {
        $this->assertGreaterThanOrEqual(
            1,
            $this->userService->get(['ID' => 'ASC'], [
                '!UF_PHONE_INNER' => null
            ], true)->getCoreResponse()->getResponseData()->getPagination()->getTotal()
        );
    }

    /**
     * @covers  \Bitrix24\SDK\Services\User\Service\User::get
     * @testdox test get users list
     * @return void
     * @throws BaseException
     * @throws TransportException
     */
    public function testGet(): void
    {
        $this->assertGreaterThanOrEqual(
            1,
            $this->userService->get(['ID' => 'ASC'], [], true)->getCoreResponse()->getResponseData()->getPagination()->getTotal()
        );
    }

    public function testUpdate(): void
    {
        $newUser = [
            'NAME' => 'Test',
            'EMAIL' => sprintf('%s.test@test.com', time()),
            'EXTRANET' => 'N',
            'UF_DEPARTMENT' => [1]
        ];
        $userId = $this->userService->add($newUser)->getId();
        $this->assertTrue($this->userService->update($userId, ['NAME' => 'Test2'])->isSuccess());
        $this->assertEquals(
            'Test2',
            $this->userService->get(['ID' => 'ASC'], [
                'ID' => $userId
            ])->getUsers()[0]->NAME
        );
    }

    /**
     * @covers  \Bitrix24\SDK\Services\User\Service\User::add
     * @testdox test add user
     * @return void
     * @throws BaseException
     * @throws TransportException
     */
    public function testAdd(): void
    {
        $newUser = [
            'NAME' => 'Test',
            'EMAIL' => sprintf('%s.test@test.com', time()),
            'EXTRANET' => 'N',
            'UF_DEPARTMENT' => [1]
        ];
        $userId = $this->userService->add($newUser)->getId();
        $this->assertGreaterThanOrEqual(1, $userId);
    }

    /**
     * @covers  \Bitrix24\SDK\Services\User\Service\User::current
     * @testdox test get current user
     * @return void
     * @throws BaseException
     * @throws TransportException
     */
    public function testUserCurrent(): void
    {
        $this->assertInstanceOf(UserItemResult::class, $this->userService->current()->user());
    }

    /**
     * @covers  \Bitrix24\SDK\Services\User\Service\User::fields
     * @testdox test get user fields
     * @return void
     * @throws BaseException
     * @throws TransportException
     */
    public function testGetUserFields(): void
    {
        $this->assertIsArray($this->userService->fields()->getFieldsDescription());
    }

    public function setUp(): void
    {
        $this->userService = Fabric::getServiceBuilder()->getUserScope()->user();
    }
}