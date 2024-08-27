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

namespace Bitrix24\SDK\Tests\Integration\Services\User\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\User\Result\UserItemResult;
use Bitrix24\SDK\Services\User\Service\User;
use Bitrix24\SDK\Services\UserConsent\Service\UserConsent;
use Bitrix24\SDK\Services\UserConsent\Service\UserConsentAgreement;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(User::class)]
class UserTest extends TestCase
{
    private User $userService;

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get users with filter')]
    public function testUserSearch(): void
    {
        $usersResult = $this->userService->search([
            'NAME' => 'test',
        ]);
        $this->assertGreaterThanOrEqual(1, $usersResult->getCoreResponse()->getResponseData()->getPagination()->getTotal());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get users list with internal phone')]
    public function testGetWithInternalPhone(): void
    {
        $this->assertGreaterThanOrEqual(
            1,
            $this->userService->get(['ID' => 'ASC'], [
                '!UF_PHONE_INNER' => null
            ], true)->getCoreResponse()->getResponseData()->getPagination()->getTotal()
        );
    }

    #[TestDox('test get users list with default arguments')]
    public function testGetWithDefaultArguments(): void
    {
        $this->assertGreaterThanOrEqual(1, $this->userService->get([], [], true)->getCoreResponse()->getResponseData()->getPagination()->getTotal());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get users list')]
    public function testGet(): void
    {
        $this->assertGreaterThanOrEqual(
            1,
            $this->userService->get(['ID' => 'ASC'], [], true)->getCoreResponse()->getResponseData()->getPagination()->getTotal()
        );
    }

    #[TestDox('test user typehints')]
    public function testGetByIdTypehints(): void
    {
        $user = $this->userService->get(['ID' => 'ASC'], [], true)->getUsers()[0];
        $this->assertIsInt($user->ID);
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
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test add user')]
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
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get current user')]
    public function testUserCurrent(): void
    {
        $this->assertInstanceOf(UserItemResult::class, $this->userService->current()->user());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get user fields')]
    public function testGetUserFields(): void
    {
        $this->assertIsArray($this->userService->fields()->getFieldsDescription());
    }

    protected function setUp(): void
    {
        $this->userService = Fabric::getServiceBuilder()->getUserScope()->user();
    }
}