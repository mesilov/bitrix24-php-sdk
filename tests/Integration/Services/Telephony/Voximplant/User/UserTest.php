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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Voximplant\User;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\MethodConfirmWaitingException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\ExternalLine;
use Bitrix24\SDK\Services\Telephony\Voximplant\User\Service\User;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(User::class)]
class UserTest extends TestCase
{
    private User $user;

    #[Test]
    #[TestDox('Method tests voximplant deactivate user phone')]
    public function testDeactivatePhone(): void
    {
        if ($this->user->core->getApiClient()->getCredentials()->isWebhookContext()) {
            $this->markTestSkipped('this method needs application context, now webhook context available');
        }

        $userId = Fabric::getServiceBuilder()->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
        $this->assertTrue($this->user->deactivatePhone($userId)->isSuccess());
    }

    #[Test]
    #[TestDox('Method tests voximplant activate user phone')]
    public function testActivatePhone(): void
    {
        if ($this->user->core->getApiClient()->getCredentials()->isWebhookContext()) {
            $this->markTestSkipped('this method needs application context, now webhook context available');
        }

        $userId = Fabric::getServiceBuilder()->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
        $this->assertTrue($this->user->activatePhone($userId)->isSuccess());
    }

    /**
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[TestDox('Method tests voximplant get user profile')]
    public function testGet(): void
    {
        if ($this->user->core->getApiClient()->getCredentials()->isWebhookContext()) {
            $this->markTestSkipped('this method needs application context, now webhook context available');
        }

        try {
            $userId = Fabric::getServiceBuilder()->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
            $users = $this->user->get([$userId, 2, 3]);
            $this->assertGreaterThanOrEqual(1, count($users->getUsers()));
        } catch (MethodConfirmWaitingException) {
            $this->markTestSkipped('api call method «voximplant.user.get» revoked, waiting confirm from portal administrator');
        }
    }

    protected function setUp(): void
    {
        $this->user = Fabric::getServiceBuilder(true)->getTelephonyScope()->getVoximplantServiceBuilder()->user();
    }
}