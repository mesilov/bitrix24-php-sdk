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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\ExternalCall\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\TelephonyCallStatusCode;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Service\ExternalCall;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Carbon\CarbonImmutable;
use Generator;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Random\RandomException;

#[CoversClass(ExternalCall::class)]
class ExternalCallTest extends TestCase
{
    private ExternalCall $externalCall;

    private ServiceBuilder $serviceBuilder;

    /**
     * @throws RandomException
     * @throws InvalidArgumentException
     * @throws BaseException
     * @throws TransportException
     */
    public static function callIdDataProvider(): Generator
    {
        $externalCall = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
        $serviceBuilder = Fabric::getServiceBuilder();

        $innerPhoneNumber = '123';
        // phone number to call
        $phoneNumber = '7978' . random_int(1000000, 9999999);
        $currentB24UserId = $serviceBuilder->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
        // set inner phone number
        $serviceBuilder->getUserScope()->user()->update(
            $currentB24UserId,
            [
                'UF_PHONE_INNER' => $innerPhoneNumber
            ]
        );
        $externalCallRegisteredResult = $externalCall->register(
            $innerPhoneNumber,
            $currentB24UserId,
            $phoneNumber,
            CarbonImmutable::now(),
            CallType::outbound,
            true,
            true,
            '3333',
            null,
            CrmEntityType::contact

        );

        yield 'default callId' => [
            $externalCallRegisteredResult->getExternalCallRegistered()->CALL_ID,
            $currentB24UserId
        ];
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Method registers a call in Bitrix24.')]
    public function testRegister(): void
    {
        $innerPhoneNumber = '123';
        // phone number to call
        $phoneNumber = '79780000000';

        $currentB24UserId = $this->serviceBuilder->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
        // set inner phone number
        $this->serviceBuilder->getUserScope()->user()->update(
            $currentB24UserId,
            [
                'UF_PHONE_INNER' => $innerPhoneNumber
            ]
        );

        $externalCallRegisteredResult = $this->externalCall->register(
            $innerPhoneNumber,
            $currentB24UserId,
            $phoneNumber,
            CarbonImmutable::now(),
            CallType::outbound,
            true,
            true,
            '3333',
            null,
            CrmEntityType::contact

        );

        $this->assertNotEmpty($externalCallRegisteredResult->getExternalCallRegistered()->CALL_ID);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[DataProvider('callIdDataProvider')]
    #[TestDox('Method tests show call ui')]
    public function testShow(string $callId, int $currentB24UserId): void
    {
        $this->assertTrue($this->externalCall->show($callId, [$currentB24UserId])->isSuccess());
    }

    #[Test]
    #[DataProvider('callIdDataProvider')]
    #[TestDox('Method tests hide call ui')]
    public function testHide(string $callId, int $currentB24UserId): void
    {
        $this->assertTrue($this->externalCall->hide($callId, [$currentB24UserId])->isSuccess());
    }

    /**
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[DataProvider('callIdDataProvider')]
    #[TestDox('Method tests finishForUserId method')]
    public function testFinishWithUserId(string $callId, int $currentB24UserId): void
    {
        $money = new Money(10000, new Currency('USD'));
        $duration = 100;

        $externalCallFinishedResult = $this->externalCall->finishForUserId(
            $callId,
            $currentB24UserId,
            $duration,
            $money,
            TelephonyCallStatusCode::successful,
            true
        );

        $this->assertTrue($externalCallFinishedResult->getExternalCallFinished()->COST->equals($money));
        $this->assertEquals($externalCallFinishedResult->getExternalCallFinished()->CALL_DURATION, $duration);

    }

    #[Test]
    #[DataProvider('callIdDataProvider')]
    #[TestDox('Method tests attachCallRecordInBase64 method')]
    public function testAttachRecordInBase64(string $callId, int $currentB24UserId): void
    {
        $money = new Money(10000, new Currency('USD'));
        $duration = 100;
        $this->externalCall->finishForUserId(
            $callId,
            $currentB24UserId,
            $duration,
            $money,
            TelephonyCallStatusCode::successful,
            true
        );
        $filename = dirname(__DIR__,2) . '/call-record-test.mp3';
        $this->assertGreaterThan(0, $this->externalCall->attachCallRecordInBase64(
            $callId,
            $filename
        )->getRecordUploadedResult()->FILE_ID);
    }

    #[Test]
    #[DataProvider('callIdDataProvider')]
    #[TestDox('Method tests getCallRecordUploadUrl method')]
    public function testGetCallRecordUploadUrl(string $callId, int $currentB24UserId): void
    {
        $this->externalCall->finishForUserId(
            $callId,
            $currentB24UserId,
            100,
            new Money(10000, new Currency('USD')),
            TelephonyCallStatusCode::successful,
            true
        );

        $filename = dirname(__DIR__,2) . '/call-record-test.mp3';
        $this->assertStringContainsString('https://', $this->externalCall->getCallRecordUploadUrl(
            $callId,
            $filename
        )->getUploadUrlResult()->uploadUrl);

    }

    public function testSearchCrmEntities(): void
    {
        $searchCrmEntitiesResult = $this->externalCall->searchCrmEntities('79780000000');
        $this->assertGreaterThanOrEqual(0, count($searchCrmEntitiesResult->getCrmEntities()));
    }

    protected function setUp(): void
    {
        $this->externalCall = Fabric::getServiceBuilder(true)->getTelephonyScope()->externalCall();
        $this->serviceBuilder = Fabric::getServiceBuilder(true);
    }
}