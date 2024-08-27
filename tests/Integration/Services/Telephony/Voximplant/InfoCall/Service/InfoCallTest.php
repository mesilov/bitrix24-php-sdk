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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Voximplant\InfoCall\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\MethodConfirmWaitingException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\ExternalLine;
use Bitrix24\SDK\Services\Telephony\Voximplant\InfoCall\Service\InfoCall;
use Bitrix24\SDK\Services\Telephony\Voximplant\Line\Service\Line;
use Bitrix24\SDK\Services\Telephony\Voximplant\User\Service\User;
use Bitrix24\SDK\Tests\Builders\DemoDataGenerator;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(InfoCall::class)]
class InfoCallTest extends TestCase
{
    private InfoCall $infoCall;

    private Line $line;

    #[Test]
    #[TestDox('Method tests voximplant info call with text')]
    public function tesStartWithText(): void
    {
        $lines = $this->line->get()->getLines();
        if ($lines === []) {
            $this->markTestSkipped('active lines not found - test start with text skipped');
        }

        $this->assertTrue($this->infoCall->startWithText(
            $lines[0]->LINE_ID,
            DemoDataGenerator::getMobilePhone()->getNationalNumber(),
            'test message'
        )->getCallResult()->RESULT);
    }

    #[Test]
    #[TestDox('Method tests voximplant info call with sound')]
    public function tesStartWithSound(): void
    {
        $lines = $this->line->get()->getLines();
        if ($lines === []) {
            $this->markTestSkipped('active lines not found - test start with text skipped');
        }

        $this->assertTrue($this->infoCall->startWithSound(
            $lines[0]->LINE_ID,
            DemoDataGenerator::getMobilePhone()->getNationalNumber(),
            DemoDataGenerator::getRecordFileUrl()
        )->getCallResult()->RESULT);
    }

    protected function setUp(): void
    {
        $this->infoCall = Fabric::getServiceBuilder(false)->getTelephonyScope()->getVoximplantServiceBuilder()->infoCall();
        $this->line = Fabric::getServiceBuilder(false)->getTelephonyScope()->getVoximplantServiceBuilder()->line();
    }
}