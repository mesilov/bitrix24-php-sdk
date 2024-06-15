<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Voximplant\Sip;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\ExternalLine;
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

    /**
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[TestDox('Method tests sip get method')]
    public function testGet(): void
    {
        $this->assertGreaterThan(0, count($this->sip->get()->getLines()));
    }

    public function testDelete(): void
    {
        $sipTitle = 'test sip - ' . Uuid::v4()->toRfc4122();
        $serverUrl = 'supersip.io';
        $login = Uuid::v4()->toRfc4122();
        $password = Uuid::v4()->toRfc4122();

        $addedLine = $this->sip->add(
            PbxType::cloud,
            $sipTitle,
            $serverUrl,
            $login,
            $password
        );
        $this->assertTrue(in_array($addedLine->getLine()->CONFIG_ID, array_column($this->sip->get()->getLines(), 'CONFIG_ID')));

        $this->assertTrue($this->sip->delete($addedLine->getLine()->CONFIG_ID)->isSuccess());

        $this->assertFalse(in_array($addedLine->getLine()->CONFIG_ID, array_column($this->sip->get()->getLines(), 'CONFIG_ID')));
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

        $addedLine = $this->sip->add(
            PbxType::cloud,
            $sipTitle,
            $serverUrl,
            $login,
            $password
        );
        $this->assertEquals($sipTitle, $addedLine->getLine()->TITLE);
        $this->assertEquals($serverUrl, $addedLine->getLine()->SERVER);
        $this->assertEquals($login, $addedLine->getLine()->LOGIN);
        $this->assertEquals($password, $addedLine->getLine()->PASSWORD);

        $this->sip->delete($addedLine->getLine()->CONFIG_ID)->isSuccess();
    }

    protected function setUp(): void
    {
        $this->sip = Fabric::getServiceBuilder()->getTelephonyScope()->getVoximplantServiceBuilder()->sip();
    }
}