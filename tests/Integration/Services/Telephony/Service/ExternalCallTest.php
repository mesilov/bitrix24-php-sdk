<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;
use _PHPStan_59fb0a3b2\Nette\Utils\DateTime;
use Bitrix24\SDK\Tests\Integration\Fabric;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class ExternalCallTest extends TestCase{
    protected ExternalCall $externalCallService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws \Exception
     * @covers ExternalCall::register_call
     */
    public function testRegisterCall():void
    {
        //Подготовка данных

        $userPhoneInner = sprintf('+%s',time());
        //$userId = (int)strtotime("+1 day");
        $userId = 1;
        $phoneNumber = '+79788045001';

        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);


        $crmCreate =  1;
        //1-звонок
        $crmSource = 1;


        $masType = array('CONTACT','COMPANY','LEAD');
        $randWord = array_rand($masType);
        $crmEntityType = $masType[$randWord];

        $crmEntityId = $randWord;


        $showCard = 1;
        $callListId = random_int(0,1000000);
        $lineNumber = (string)strtotime("+5 day");
        $typeCall = random_int(1,4);

        // Тест
        self::assertGreaterThan(1,$this->externalCallService->register_call($userPhoneInner,$userId,$phoneNumber,$callStartDate,$crmCreate,$crmSource,$crmEntityType,
            $crmEntityId,$showCard,$callListId,$lineNumber,$typeCall)->getExternalCallRegister());
    }
    /**
     * @throws BaseException
     * @throws TransportException
     * @throws \Exception
     * @covers ExternalCall::showCallCard
     */
    public function testShowCallCard():void{

    }
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalCallService = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
    }
}