<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\ExternalCall\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Service\ExternalCall;
use Bitrix24\SDK\Services\Telephony;
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
        $res = $externalCall->register(
            $innerPhoneNumber,
            $currentB24UserId,
            $phoneNumber,
            CarbonImmutable::now(),
            Telephony\Common\CallType::outbound,
            true,
            true,
            '3333',
            null,
            Telephony\Common\CrmEntityType::contact

        );

        yield 'default callId' => [
            $res->getExternalCallRegistered()->CALL_ID,
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

        $res = $this->externalCall->register(
            $innerPhoneNumber,
            $currentB24UserId,
            $phoneNumber,
            CarbonImmutable::now(),
            Telephony\Common\CallType::outbound,
            true,
            true,
            '3333',
            null,
            Telephony\Common\CrmEntityType::contact

        );

        $this->assertNotEmpty($res->getExternalCallRegistered()->CALL_ID);
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

        $fr = $this->externalCall->finishForUserId(
            $callId,
            $currentB24UserId,
            $duration,
            $money,
            Telephony\Common\TelephonyCallStatusCode::successful,
            true
        );

        $this->assertTrue($fr->getExternalCallFinished()->COST->equals($money));
        $this->assertEquals($fr->getExternalCallFinished()->CALL_DURATION, $duration);

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
            Telephony\Common\TelephonyCallStatusCode::successful,
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
            Telephony\Common\TelephonyCallStatusCode::successful,
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