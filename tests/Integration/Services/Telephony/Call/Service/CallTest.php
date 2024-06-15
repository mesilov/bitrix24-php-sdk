<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Call\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\Telephony;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessage;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessageSide;
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

#[CoversClass(Telephony\Call\Service\Call::class)]
class CallTest extends TestCase
{
    private Telephony\Call\Service\Call $call;
    private ExternalCall $externalCall;
    private ServiceBuilder $sb;

    /**
     * @throws RandomException
     * @throws InvalidArgumentException
     * @throws BaseException
     * @throws TransportException
     */
    public static function callIdDataProvider(): Generator
    {
        $externalCall = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
        $sb = Fabric::getServiceBuilder();

        $innerPhoneNumber = '123';
        // phone number to call
        $phoneNumber = sprintf('7978' . random_int(1000000, 9999999));
        $currentB24UserId = $sb->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
        // set inner phone number
        $sb->getUserScope()->user()->update(
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
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[DataProvider('callIdDataProvider')]
    #[TestDox('Method tests attachTranscription method')]
    public function testFinishWithUserId(string $callId, int $currentB24UserId): void
    {
        $cost = new Money(30000, new Currency('USD'));
        $duration = 100;

        $this->externalCall->finishForUserId(
            $callId,
            $currentB24UserId,
            $duration,
            $cost,
            Telephony\Common\TelephonyCallStatusCode::successful,
            true
        );

        $filename = dirname(__DIR__, 2) . '/call-record-test.mp3';
        $this->externalCall->attachCallRecordInBase64(
            $callId,
            $filename
        );

        $res = $this->call->attachTranscription(
            $callId,
            $cost,
            [
                new TranscriptMessage(TranscriptMessageSide::user, 1, 5, "We're no strangers to love"),
                new TranscriptMessage(TranscriptMessageSide::client, 5, 10, "You know the rules and so do I (do I)"),
                new TranscriptMessage(TranscriptMessageSide::user, 10, 15, "A full commitment's what I'm thinking of"),
                new TranscriptMessage(TranscriptMessageSide::client, 15, 20, "You wouldn't get this from any other guy"),
                new TranscriptMessage(TranscriptMessageSide::user, 20, 25, "I just wanna tell you how I'm feeling"),
                new TranscriptMessage(TranscriptMessageSide::client, 25, 30, "Gotta make you understand"),
                new TranscriptMessage(TranscriptMessageSide::user, 30, 35, "Never gonna give you up"),
                new TranscriptMessage(TranscriptMessageSide::client, 35, 40, "Never gonna let you down"),
                new TranscriptMessage(TranscriptMessageSide::user, 40, 45, "Never gonna run around and desert you"),
                new TranscriptMessage(TranscriptMessageSide::client, 45, 50, "Never gonna make you cry"),
                new TranscriptMessage(TranscriptMessageSide::user, 50, 55, "Never gonna say goodbye"),
                new TranscriptMessage(TranscriptMessageSide::client, 55, 60, "Never gonna tell a lie and hurt you"),
            ]
        );

        $this->assertGreaterThan(0, $res->getTranscriptAttachItem()->TRANSCRIPT_ID);
    }

    public function setUp(): void
    {
        $this->call = Fabric::getServiceBuilder(true)->getTelephonyScope()->call();
        $this->externalCall = Fabric::getServiceBuilder(true)->getTelephonyScope()->externalCall();
        $this->sb = Fabric::getServiceBuilder(true);
    }
}