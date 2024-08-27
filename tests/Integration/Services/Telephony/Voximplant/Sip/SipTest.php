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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Voximplant\Sip;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Service\Sip;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Sip::class)]
class SipTest extends TestCase
{
    private Sip $sip;

    #[Test]
    #[TestDox('Method tests return current status of the SIP Connector')]
    public function testGetConnectorStatus():void
    {
        $this->assertGreaterThanOrEqual(0, $this->sip->getConnectorStatus()->getStatus()->FREE_MINUTES);
    }

    /**
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[TestDox('Method tests sip get method')]
    public function testGet(): void
    {
        $sipTitle = 'test sip - ' . Uuid::v4()->toRfc4122();
        $serverUrl = 'supersip.io';
        $login = Uuid::v4()->toRfc4122();
        $password = Uuid::v4()->toRfc4122();

        $sipLineAddedResult = $this->sip->add(
            PbxType::cloud,
            $sipTitle,
            $serverUrl,
            $login,
            $password
        );
        $this->assertGreaterThanOrEqual(1, count($this->sip->get()->getLines()));
        $this->assertTrue($this->sip->delete($sipLineAddedResult->getLine()->CONFIG_ID)->isSuccess());
    }

    #[Test]
    #[TestDox('Method tests sip delete line method')]
    public function testDelete(): void
    {
        $sipTitle = 'test sip - ' . Uuid::v4()->toRfc4122();
        $serverUrl = 'supersip.io';
        $login = Uuid::v4()->toRfc4122();
        $password = Uuid::v4()->toRfc4122();

        $sipLineAddedResult = $this->sip->add(
            PbxType::cloud,
            $sipTitle,
            $serverUrl,
            $login,
            $password
        );
        $this->assertTrue(in_array($sipLineAddedResult->getLine()->CONFIG_ID, array_column($this->sip->get()->getLines(), 'CONFIG_ID')));

        $this->assertTrue($this->sip->delete($sipLineAddedResult->getLine()->CONFIG_ID)->isSuccess());

        $this->assertFalse(in_array($sipLineAddedResult->getLine()->CONFIG_ID, array_column($this->sip->get()->getLines(), 'CONFIG_ID')));
    }

    /**
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[TestDox('Method tests sip add line method')]
    public function testAdd(): void
    {
        $sipTitle = 'test sip - ' . Uuid::v4()->toRfc4122();
        $serverUrl = 'supersip.io';
        $login = Uuid::v4()->toRfc4122();
        $password = Uuid::v4()->toRfc4122();

        $sipLineAddedResult = $this->sip->add(
            PbxType::cloud,
            $sipTitle,
            $serverUrl,
            $login,
            $password
        );
        $this->assertEquals($sipTitle, $sipLineAddedResult->getLine()->TITLE);
        $this->assertEquals($serverUrl, $sipLineAddedResult->getLine()->SERVER);
        $this->assertEquals($login, $sipLineAddedResult->getLine()->LOGIN);
        $this->assertEquals($password, $sipLineAddedResult->getLine()->PASSWORD);

        $this->sip->delete($sipLineAddedResult->getLine()->CONFIG_ID)->isSuccess();
    }

    #[Test]
    #[TestDox('Method tests sip update line method')]
    public function testUpdate(): void
    {
        $sipTitle = 'test sip - ' . Uuid::v4()->toRfc4122();
        $serverUrl = 'supersip.io';
        $login = Uuid::v4()->toRfc4122();
        $password = Uuid::v4()->toRfc4122();

        $sipLineAddedResult = $this->sip->add(
            PbxType::cloud,
            $sipTitle,
            $serverUrl,
            $login,
            $password
        );

        $newTitle = 'test sip updated title - ' . Uuid::v4()->toRfc4122();
        $this->assertTrue($this->sip->update(
            $sipLineAddedResult->getLine()->CONFIG_ID,
            $sipLineAddedResult->getLine()->TYPE,
            $newTitle
        )->isSuccess());


        $this->sip->delete($sipLineAddedResult->getLine()->CONFIG_ID)->isSuccess();
    }

    #[Test]
    #[TestDox('Method tests sip get line status method')]
    public function testStatus(): void
    {
        $sipTitle = 'test sip - ' . Uuid::v4()->toRfc4122();
        $serverUrl = 'supersip.io';
        $login = Uuid::v4()->toRfc4122();
        $password = Uuid::v4()->toRfc4122();

        $sipLineAddedResult = $this->sip->add(
            PbxType::cloud,
            $sipTitle,
            $serverUrl,
            $login,
            $password
        );

        $sipLineStatusItemResult = $this->sip->status($sipLineAddedResult->getLine()->REG_ID)->getStatus();
        $this->assertEquals($sipLineAddedResult->getLine()->REG_ID, $sipLineStatusItemResult->REG_ID);

        $this->sip->delete($sipLineAddedResult->getLine()->CONFIG_ID);
    }

    /**
     * @throws TransportException
     * @throws BaseException
     */
    protected function tearDown(): void
    {
        //delete all cloud pbx
        $lines = $this->sip->get()->getLines();
        foreach ($lines as $line) {
            $this->sip->delete($line->CONFIG_ID);
        }
    }

    protected function setUp(): void
    {
        $this->sip = Fabric::getServiceBuilder()->getTelephonyScope()->getVoximplantServiceBuilder()->sip();
    }
}