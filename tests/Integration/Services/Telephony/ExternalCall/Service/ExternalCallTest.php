<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\ExternalCall\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\Telephony;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

class ExternalCallTest extends TestCase
{
    private Telephony\ExternalCall\Service\ExternalCall $externalCall;
    private ServiceBuilder $sb;

    /**
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\Telephony\ExternalCall\Service\ExternalCall::register
     * @testdox Method registers a call in Bitrix24.
     */
    public function testRegister(): void
    {
        $innerPhoneNumber = '123';
        // phone number to call
        $phoneNumber = '79780000000';

        //todo set userInnerPhone number
        $currentB24UserId = $this->sb->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
        // set inner phone number
        $this->sb->getUserScope()->user()->update(
            $currentB24UserId,
            [
                'UF_PHONE_INNER' => $innerPhoneNumber
            ]
        );

        $res = $this->externalCall->register(
            '111123',
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


    public function setUp(): void
    {
        $this->externalCall = Fabric::getServiceBuilder(true)->getTelephonyScope()->externalCall();
        $this->sb = Fabric::getServiceBuilder(true);
    }
}