<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Lead\Service\Lead;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;
use _PHPStan_59fb0a3b2\Nette\Utils\DateTime;
use Bitrix24\SDK\Tests\Integration\Fabric;
use DateTimeInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class ExternalCallTest extends TestCase
{
    protected Lead $leadService;
    protected ExternalCall $externalCallService;
    private Main $mainService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws Exception
     * @covers ExternalCall::registerCall
     */
    public function testRegisterCall(): void
    {
        //Подготовка данных
        // Тест
       (string)$datetime = new DateTime('now');
       $callStartDate = $datetime->format(DateTimeInterface::ATOM);
       $leadId =  $this->leadService->add(['TITLE' => 'test lead'])->getId();
       $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
       $res =  $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'USER_ID' => $userId,
            'PHONE_NUMBER' => '+79788045001',
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 1,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => 'LEAD',
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => '+79767867656',
            'TYPE' => 1,
        ])->getExternalCallRegister();
        var_dump($res);
        self::assertGreaterThan(1,$res);
        self::assertTrue((bool)$res);

    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws Exception
     * @covers ExternalCall::showCallCard
     */
    public function testShowCallCard(): void
    {
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $leadId =  $this->leadService->add(['TITLE' => 'test lead'])->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $res =  $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'USER_ID' => $userId,
            'PHONE_NUMBER' => '+79788045001',
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 1,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => 'LEAD',
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => '+79767867656',
            'TYPE' => 1
        ])->getExternalCallRegister()->CALL_ID;
        $newRes = $this->externalCallService->showCallCard($res, 1);
        var_dump($newRes);
        self::assertGreaterThan(1,$this->externalCallService->showCallCard($res, 1));
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws Exception
     * @covers ExternalCall::hideCallCard
     */
    public function testHideCallCard(): void
    {
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $leadId =  $this->leadService->add(['TITLE' => 'test lead'])->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $res =  $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'user_id' => $userId,
            'PHONE_NUMBER' => '+79788045001',
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 1,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => 'LEAD',
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => '+79767867656',
            'TYPE' => 1
        ])->getExternalCallRegister()->CALL_ID;
        $newRes = $this->externalCallService->hideCallCard($res, 1)->getExternalHideCalls();
        var_dump($newRes);
        self::assertTrue($this->externalCallService->hideCallCard($res, 1)->getExternalHideCalls());
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::finishСall
     */
    public function testFinishCall(): void
    {
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $leadId =  $this->leadService->add(['TITLE' => 'test lead'])->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $res =  $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'user_id' => $userId,
            'PHONE_NUMBER' => '+79788045001',
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 1,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => 'LEAD',
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => '+79767867656',
            'TYPE' => 1
        ])->getExternalCallRegister();

        $newRes = $this->externalCallService->finishCall([
            'CALL_ID'=>$res->CALL_ID,
            'USER_ID'=>$userId,
            'DURATION'=>255,
            'COST'=>5000,
            'COST_CURRENCY'=>'RUB',
            'STATUS_CODE'=>'VI_STATUS_304',
            'FAILED_REASON'=>'',
            'RECORD_URL'=>'',
            'VOTE'=>5,
            'ADD_TO_CHAT'=>1
            ])->getExternalCallFinish();
        var_dump($newRes);
        self::assertTrue((bool)$newRes);
        self::assertContains($res->CALL_ID,$newRes);
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::attachRecord
     */
    public function testRecordCall(): void
    {
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $leadId =  $this->leadService->add(['TITLE' => 'test lead'])->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $res =  $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'user_id' => $userId,
            'PHONE_NUMBER' => '+79788045001',
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 1,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => 'LEAD',
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => '+79767867656',
            'TYPE' => 1
        ])->getExternalCallRegister()->CALL_ID;

        $newRes = $this->externalCallService->finishCall([
            'CALL_ID'=>$res,
            'USER_ID'=>$userId,
            'DURATION'=>255,
            'COST'=>5000,
            'COST_CURRENCY'=>'RUB',
            'STATUS_CODE'=>'VI_STATUS_304',
            'FAILED_REASON'=>'',
            'RECORD_URL'=>'',
            'VOTE'=>5,
            'ADD_TO_CHAT'=>1
        ])->getExternalCallFinish();

        $fileName = sprintf('test%s', time());
        //Декодирование в base64 разобраться с этим.
        $content = 'filesss';
        $url = 'https://vk.com/audio172690992_456241640_4836017d770715b9af';
        self::assertGreaterThan(1, $this->externalCallService->attachRecord($res, $fileName, $content, $url)->getRecord());
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalCallService = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
    }
}