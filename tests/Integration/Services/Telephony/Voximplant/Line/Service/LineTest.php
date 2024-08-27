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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Voximplant\Line\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\MethodConfirmWaitingException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\ExternalLine;
use Bitrix24\SDK\Services\Telephony\Voximplant\InfoCall\Service\InfoCall;
use Bitrix24\SDK\Services\Telephony\Voximplant\Line\Service\Line;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Service\Sip;
use Bitrix24\SDK\Services\Telephony\Voximplant\User\Service\User;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Line::class)]
class LineTest extends TestCase
{
    private Line $line;

    private Sip $sip;

    #[Test]
    #[TestDox('Method tests returns list of all of the available outgoing lines')]
    public function testOutgoingSipSet(): void
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

        $this->assertTrue($this->line->outgoingSipSet($sipLineAddedResult->getLine()->ID)->isSuccess());
        $this->sip->delete($sipLineAddedResult->getLine()->ID);
    }

    #[Test]
    #[TestDox('Method tests returns list of all of the available outgoing lines')]
    public function testGet(): void
    {
        $this->assertGreaterThanOrEqual(0, count($this->line->get()->getLines()));
    }

    #[Test]
    #[TestDox('Method tests returns the currently selected line as an outgoing line by default.')]
    public function testOutgoingGet(): void
    {
        $this->assertNotEmpty($this->line->outgoingGet()->getLineId()->LINE_ID);
    }

    #[Test]
    #[TestDox('Method sets the selected line as an outgoing line by default.')]
    public function testOutgoingSet(): void
    {
       $this->assertTrue($this->line->outgoingSet('1')->isSuccess());
    }

    protected function setUp(): void
    {
        $this->line = Fabric::getServiceBuilder(false)->getTelephonyScope()->getVoximplantServiceBuilder()->line();
        $this->sip = Fabric::getServiceBuilder(false)->getTelephonyScope()->getVoximplantServiceBuilder()->sip();
    }
}