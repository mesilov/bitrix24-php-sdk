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

namespace Bitrix24\SDK\Tests\Integration\Services\IM\Notify\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\IM\Notify\Service\Notify;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Notify::class)]
class NotifyTest extends TestCase
{
    private Notify $imNotifyService;

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test send notification from system')]
    public function testFromSystem(): void
    {
        $addedItemResult = $this->imNotifyService->fromSystem(
            (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message at %s', time())
        );
        $this->assertGreaterThan(0, $addedItemResult->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test send notification from personal')]
    public function testFromPersonal(): void
    {
        $addedItemResult = $this->imNotifyService->fromPersonal(
            (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message at %s', time())
        );
        $this->assertGreaterThan(0, $addedItemResult->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test delete notification')]
    public function testDelete(): void
    {
        $addedItemResult = $this->imNotifyService->fromSystem(
            (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message for delete at %s', time())
        );
        $this->assertGreaterThan(0, $addedItemResult->getId());
        $this->assertTrue($this->imNotifyService->delete($addedItemResult->getId())->isSuccess());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test mark as read notification')]
    public function testMarkAsRead(): void
    {
        $addedItemResult = $this->imNotifyService->fromSystem(
            (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message for mark as read at %s', time())
        );
        $this->assertGreaterThan(0, $addedItemResult->getId());
        $this->assertTrue($this->imNotifyService->markAsRead($addedItemResult->getId())->isSuccess());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test mark messages as read')]
    public function testMarkMessagesAsRead(): void
    {
        $messageIds = [];
        for ($i = 0; $i < 5; $i++) {
            $messageIds[] = $this->imNotifyService->fromSystem(
                (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
                sprintf('Test message for mark as read at %s', time())
            )->getId();
        }

        $this->assertTrue($this->imNotifyService->markMessagesAsRead($messageIds)->isSuccess());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test mark messages as unread')]
    public function testMarkMessagesAsUnread(): void
    {
        $messageIds = [];
        for ($i = 0; $i < 5; $i++) {
            $messageIds[] = $this->imNotifyService->fromSystem(
                (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
                sprintf('Test message for mark as read at %s', time())
            )->getId();
        }

        $this->assertTrue($this->imNotifyService->markMessagesAsRead($messageIds)->isSuccess());
        $this->assertTrue($this->imNotifyService->markMessagesAsUnread($messageIds)->isSuccess());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test mark messages as answered')]
    public function testAnswer(): void
    {
        $addedItemResult = $this->imNotifyService->fromPersonal(
            (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message at %s', time())
        );
        $this->assertGreaterThan(0, $addedItemResult->getId());

        $this->imNotifyService->answer($addedItemResult->getId(), 'reply text');
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test Interaction with notification buttons')]
    public function testConfirm(): void
    {
        $addedItemResult = $this->imNotifyService->fromPersonal(
            (int)$this->imNotifyService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message at %s', time())
        );
        $this->assertGreaterThan(0, $addedItemResult->getId());

        $this->imNotifyService->confirm($addedItemResult->getId(), true);
    }

    protected function setUp(): void
    {
        $this->imNotifyService = Fabric::getServiceBuilder()->getIMScope()->notify();
    }
}