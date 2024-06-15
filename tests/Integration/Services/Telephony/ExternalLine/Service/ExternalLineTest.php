<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\ExternalLine\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\Telephony;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessage;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessageSide;
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

#[CoversClass(Telephony\ExternalLine\Service\ExternalLine::class)]
class ExternalLineTest extends TestCase
{
    private Telephony\ExternalLine\Service\ExternalLine $externalLine;

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
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[TestDox('Method tests add external line method')]
    public function testExternalLineAdd(): void
    {
        $lineNumber = (string)time();
        $res = $this->externalLine->add($lineNumber, true, sprintf('line-name-%s', $lineNumber));
        $this->assertGreaterThan(0, $res->getExternalLineAddResultItem()->ID);
    }

    protected function setUp(): void
    {
        $this->externalLine = Fabric::getServiceBuilder(true)->getTelephonyScope()->externalLine();
    }
}