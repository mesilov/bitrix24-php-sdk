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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Call\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Call\Service\Call;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\TelephonyCallStatusCode;
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

#[CoversClass(Call::class)]
class CallTest extends TestCase
{
    private Call $call;

    private ExternalCall $externalCall;

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
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[DataProvider('callIdDataProvider')]
    #[TestDox('Method tests attachTranscription method')]
    public function testFinishWithUserId(string $callId, int $currentB24UserId): void
    {
        $money = new Money(30000, new Currency('USD'));
        $duration = 100;

        $this->externalCall->finishForUserId(
            $callId,
            $currentB24UserId,
            $duration,
            $money,
            TelephonyCallStatusCode::successful,
            true
        );

        $filename = dirname(__DIR__, 2) . '/call-record-test.mp3';
        $this->externalCall->attachCallRecordInBase64(
            $callId,
            $filename
        );

        $transcriptAttachedResult = $this->call->attachTranscription(
            $callId,
            $money,
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

        $this->assertGreaterThan(0, $transcriptAttachedResult->getTranscriptAttachItem()->TRANSCRIPT_ID);
    }

    protected function setUp(): void
    {
        $this->call = Fabric::getServiceBuilder(true)->getTelephonyScope()->call();
        $this->externalCall = Fabric::getServiceBuilder(true)->getTelephonyScope()->externalCall();
    }
}