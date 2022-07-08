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

        //Внутренний номер пользователя.
        $userPhoneInner = '+79788045002';
        //Идентификатор пользователя.
        $userId = 1;
        //Номер с которого звоним.
        $phoneNumber = '+79788045001';
        //Дата/время звонка
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        //[0/1] - Автоматическое создание в CRM сущности, связанной со звонком.
        $crmCreate =  1;
        //1-звонок
        $crmSource = 1;
        //Тип объекта CRM, из карточки которого совершается звонок
        /* $masType = array('CONTACT','COMPANY','LEAD');
       $randWord = array_rand($masType);
        $crmEntityType = $masType[$randWord];*/
        //Не уверен, что правильно
        $crmEntityType = 'COMPANY';
        $crmEntityId = 1;
        //Показывать карточку или нет.
        $showCard = 1;
        //Идентификатор списка обзвона, к которому должен быть привязан звонок. (ГДЕ НАЙТИ СПИСОК ОБЗВОНА???)
        $callListId = 1;
        //Номер на который поступает звонок
        $lineNumber = '+79767867656';
       /* Обязательный. Тип звонка:
        1 - исходящий
        2 - входящий
        3 - входящий с перенаправлением
        4 - обратный*/
        $typeCall = 1;

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
        //Внутренний номер пользователя.
        $userPhoneInner = '+79788045002';
        //Идентификатор пользователя.
        $userId = 1;
        //Номер с которого звоним.
        $phoneNumber = '+79788045001';
        //Дата/время звонка
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        //[0/1] - Автоматическое создание в CRM сущности, связанной со звонком.
        $crmCreate =  1;
        //1-звонок
        $crmSource = 1;
        //Тип объекта CRM, из карточки которого совершается звонок
         $masType = array('CONTACT','COMPANY','LEAD');
       $randWord = array_rand($masType);
        $crmEntityType = $masType[$randWord];
        $crmEntityId = $randWord;
        //Не уверен, что правильно
       // $crmEntityType = 'COMPANY';
      //  $crmEntityId = 1;
        //Показывать карточку или нет.
        $showCard = 1;
        //Идентификатор списка обзвона, к которому должен быть привязан звонок. (ГДЕ НАЙТИ СПИСОК ОБЗВОНА???)
        $callListId = 1;
        //Номер на который поступает звонок
        $lineNumber = '+79767867658';
        /* Обязательный. Тип звонка:
         1 - исходящий
         2 - входящий
         3 - входящий с перенаправлением
         4 - обратный*/
        $typeCall = 4;

        $res = [];
        $res=$this->externalCallService->register_call($userPhoneInner,$userId,$phoneNumber,$callStartDate,$crmCreate,$crmSource,$crmEntityType, $crmEntityId,$showCard,$callListId,$lineNumber,$typeCall)->getExternalCallRegister();
        self::assertGreaterThan(1,$this->externalCallService->showCallCard($res['CALL_ID'],1)->getExternalCalls());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws \Exception
     * @covers ExternalCall::hideCallCard
     */
    public function testHideCallCard():void{
        //Внутренний номер пользователя.
        $userPhoneInner = '+79788045002';
        //Идентификатор пользователя.
        $userId = 1;
        //Номер с которого звоним.
        $phoneNumber = '+79788045001';
        //Дата/время звонка
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        //[0/1] - Автоматическое создание в CRM сущности, связанной со звонком.
        $crmCreate =  1;
        //1-звонок
        $crmSource = 1;
        //Тип объекта CRM, из карточки которого совершается звонок
        $masType = array('CONTACT','COMPANY','LEAD');
        $randWord = array_rand($masType);
        $crmEntityType = $masType[$randWord];
        $crmEntityId = $randWord;
        //Не уверен, что правильно
        // $crmEntityType = 'COMPANY';
        //  $crmEntityId = 1;
        //Показывать карточку или нет.
        $showCard = 1;
        //Идентификатор списка обзвона, к которому должен быть привязан звонок. (ГДЕ НАЙТИ СПИСОК ОБЗВОНА???)
        $callListId = 1;
        //Номер на который поступает звонок
        $lineNumber = '+79767867658';
        /* Обязательный. Тип звонка:
         1 - исходящий
         2 - входящий
         3 - входящий с перенаправлением
         4 - обратный*/
        $typeCall = 4;

        $res = [];
        $res=$this->externalCallService->register_call($userPhoneInner,$userId,$phoneNumber,$callStartDate,$crmCreate,$crmSource,$crmEntityType, $crmEntityId,$showCard,$callListId,$lineNumber,$typeCall)->getExternalCallRegister();
        self::assertGreaterThan(1,$this->externalCallService->hideCallCard($res['CALL_ID'],1)->getExternalHideCalls());
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws \Exception
     * @covers ExternalCall::finish_call
     */
    public function testFinishCall():void{
        //Внутренний номер пользователя.
        $userPhoneInner = '+79788045002';
        //Идентификатор пользователя.
        $userId = 1;
        //Номер с которого звоним.
        $phoneNumber = '+79788045001';
        //Дата/время звонка
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        //[0/1] - Автоматическое создание в CRM сущности, связанной со звонком.
        $crmCreate =  1;
        //1-звонок
        $crmSource = 1;
        //Тип объекта CRM, из карточки которого совершается звонок
        $masType = array('CONTACT','COMPANY','LEAD');
        $randWord = array_rand($masType);
        $crmEntityType = $masType[$randWord];
        $crmEntityId = $randWord;
        //Не уверен, что правильно
        // $crmEntityType = 'COMPANY';
        //  $crmEntityId = 1;
        //Показывать карточку или нет.
        $showCard = 1;
        //Идентификатор списка обзвона, к которому должен быть привязан звонок. (ГДЕ НАЙТИ СПИСОК ОБЗВОНА???)
        $callListId = 1;
        //Номер на который поступает звонок
        $lineNumber = '+79767867658';
        /* Обязательный. Тип звонка:
         1 - исходящий
         2 - входящий
         3 - входящий с перенаправлением
         4 - обратный*/
        $typeCall = 2;

        $res = [];
        $res=$this->externalCallService->register_call($userPhoneInner,$userId,$phoneNumber,$callStartDate,$crmCreate,$crmSource,$crmEntityType, $crmEntityId,$showCard,$callListId,$lineNumber,$typeCall)->getExternalCallRegister();

        //Подготовка
        $call_id = $res['CALL_ID'];
        $user_Id = 1;
        $duration = 255;
        $cost =  5000;
        $cosy_currency = 'RUB';
        $status_code  = 'VI_STATUS_304';
        $failed_reason = '';
        $record_url = '';
        $vote = 5;
        $add_to_chat = 1;
        self::assertGreaterThan(1,$this->externalCallService->finish_call($call_id,$user_Id,$duration,$cost,$cosy_currency,$status_code,$failed_reason,$record_url,$vote,$add_to_chat)->getFinishCallResult());
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws \Exception
     * @covers ExternalCall::attachRecord
     */
    public function testRecordCall():void
    {
        //Внутренний номер пользователя.
        $userPhoneInner = '+79788045002';
        //Идентификатор пользователя.
        $userId = 1;
        //Номер с которого звоним.
        $phoneNumber = '+79788045001';
        //Дата/время звонка
        (string)$datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        //[0/1] - Автоматическое создание в CRM сущности, связанной со звонком.
        $crmCreate =  1;
        //1-звонок
        $crmSource = 1;
        //Тип объекта CRM, из карточки которого совершается звонок
        $masType = array('CONTACT','COMPANY','LEAD');
        $randWord = array_rand($masType);
        $crmEntityType = $masType[$randWord];
        $crmEntityId = $randWord;
        //Не уверен, что правильно
        // $crmEntityType = 'COMPANY';
        //  $crmEntityId = 1;
        //Показывать карточку или нет.
        $showCard = 1;
        //Идентификатор списка обзвона, к которому должен быть привязан звонок. (ГДЕ НАЙТИ СПИСОК ОБЗВОНА???)
        $callListId = 1;
        //Номер на который поступает звонок
        $lineNumber = '+79767867658';
        /* Обязательный. Тип звонка:
         1 - исходящий
         2 - входящий
         3 - входящий с перенаправлением
         4 - обратный*/
        $typeCall = 2;

        $res = [];
        $res=$this->externalCallService->register_call($userPhoneInner,$userId,$phoneNumber,$callStartDate,$crmCreate,$crmSource,$crmEntityType, $crmEntityId,$showCard,$callListId,$lineNumber,$typeCall)->getExternalCallRegister();

        //Подготовка
        $call_id = $res['CALL_ID'];
        $user_Id = 1;
        $duration = 255;
        $cost =  5000;
        $cosy_currency = 'RUB';
        $status_code  = 'VI_STATUS_304';
        $failed_reason = '';
        $record_url = '';
        $vote = 5;
        $add_to_chat = 1;
        $this->externalCallService->finish_call($call_id,$user_Id,$duration,$cost,$cosy_currency,$status_code,$failed_reason,$record_url,$vote,$add_to_chat)->getFinishCallResult();

        $fileName = 'testFiless';
        //Декодирование в base64 разобраться с этим.
        $content = 'filesss';
        $url = 'https://vk.com/audio172690992_456241726_c88e19185934f5b9dd';
        self::assertGreaterThan(1,$this->externalCallService->attachRecord($call_id,$fileName,$content,$url)->getRecord());
    }
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalCallService = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
    }
}