<?php

declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;


use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\CRM\Lead\Service\Lead;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\StatusSipCodeInterface;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;
use Bitrix24\SDK\Tests\Integration\Fabric;
use DateTime;
use DateTimeInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class ExternalCallTest extends TestCase
{
    protected Lead $leadService;
    protected ExternalCall $externalCallService;
    private Main $mainService;
    protected Contact $contactService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws Exception
     * @covers ExternalCall::registerCall
     */

    public function testRegisterCall(): void
    {
        $datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $phoneNumber = sprintf('+7%s', time());
        $leadId = $this->leadService->add(
            [
                'TITLE' => 'test lead',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumber,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $registerCallResult = $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'USER_ID' => $userId,
            'PHONE_NUMBER' => $phoneNumber,
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 0,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => (string)CrmEntityType::lead(),
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => $phoneNumber,
            'TYPE' => (string)CallType::inboundCall(),
        ])->getExternalCallRegister();

        self::assertTrue((bool)$registerCallResult);
        self::assertEquals($registerCallResult->CRM_ENTITY_ID, $leadId, sprintf('registered entity id : %s , and lead id: %s, should not differ',
            $registerCallResult->CRM_ENTITY_ID, $leadId));
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws Exception
     * @covers ExternalCall::show
     */


    public function testShowCallCard(): void
    {
        $datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $phoneNumber = '+79788045001';
        $leadId = $this->leadService->add(
            [
                'TITLE' => 'test lead',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumber,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $registerCallResult = $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'USER_ID' => $userId,
            'PHONE_NUMBER' => $phoneNumber,
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 0,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => (string)CrmEntityType::lead(),
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 0,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => $phoneNumber,
            'TYPE' => (string)CallType::inboundCall(),
        ])->getExternalCallRegister();
        self::assertTrue($this->externalCallService->show($registerCallResult->CALL_ID, $userId)->isShown());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws Exception
     * @covers ExternalCall::hide
     */
    public function testHideCallCard(): void
    {
        $datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $phoneNumber = '+79788045001';
        $leadId = $this->leadService->add(
            [
                'TITLE' => 'test lead',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumber,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $registerCallResult = $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'USER_ID' => $userId,
            'PHONE_NUMBER' => $phoneNumber,
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 0,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => (string)CrmEntityType::lead(),
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 0,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => $phoneNumber,
            'TYPE' => (string)CallType::inboundCall(),
        ])->getExternalCallRegister();
        self::assertTrue($this->externalCallService->hide($registerCallResult->CALL_ID, $userId)->isHided());
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::finish
     */
    public function testFinish(): void
    {
        $datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $phoneNumber = sprintf('+7%s', time());
        $leadId = $this->leadService->add(
            [
                'TITLE' => 'test lead',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumber,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $registerCallResult = $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'USER_ID' => $userId,
            'PHONE_NUMBER' => $phoneNumber,
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 0,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => (string)CrmEntityType::lead(),
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => $phoneNumber,
            'TYPE' => (string)CallType::inboundCall(),
        ])->getExternalCallRegister();

        $finishCallResult = $this->externalCallService->finish([
            'CALL_ID' => $registerCallResult->CALL_ID,
            'USER_ID' => $userId,
            'DURATION' => 255,
            'COST' => 250,
            'COST_CURRENCY' => 'RUB',
            'STATUS_CODE' => StatusSipCodeInterface::STATUS_OK,
            'FAILED_REASON' => '',
            'RECORD_URL' => '',
            'VOTE' => 5,
            'ADD_TO_CHAT' => 1
        ])->getExternalCallFinish();

        self::assertEquals($registerCallResult->CALL_ID, $finishCallResult->CALL_ID, sprintf('registered: %s , and finish: %s, CALL_ID do not match',
            $registerCallResult->CALL_ID, $finishCallResult->CALL_ID));

        self::assertEquals($registerCallResult->CRM_ENTITY_ID, $finishCallResult->CRM_ENTITY_ID, sprintf('registered: %s , and finish: %s, ENTITY_ID do not match',
            $registerCallResult->CRM_ENTITY_ID, $finishCallResult->CRM_ENTITY_ID));

        self::assertNotEmpty($finishCallResult->CALL_DURATION, 'call time cannot be empty');
        self::assertNotEmpty($finishCallResult->COST, 'call cost cannot be empty');
        self::assertNotEmpty($finishCallResult->CALL_STATUS, 'status code must return call code and cannot be empty');
        self::assertNotEmpty($finishCallResult->PHONE_NUMBER, 'phone number cannot be empty');
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::attachRecord
     */
    public function testAttachRecord(): void
    {
        $datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $phoneNumber = sprintf('+7%s', time());
        $leadId = $this->leadService->add(
            [
                'TITLE' => 'test lead',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumber,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $userId = $this->mainService->getCurrentUserProfile()->getUserProfile()->ID;
        $registerCallResult = $this->externalCallService->registerCall([
            'USER_PHONE_INNER' => '14',
            'USER_ID' => $userId,
            'PHONE_NUMBER' => $phoneNumber,
            'CALL_START_DATE' => $callStartDate,
            'CRM_CREATE' => 0,
            'CRM_SOURCE' => '1',
            'CRM_ENTITY_TYPE' => (string)CrmEntityType::lead(),
            'CRM_ENTITY_ID' => $leadId,
            'SHOW' => 1,
            'CALL_LIST_ID' => 1,
            'LINE_NUMBER' => $phoneNumber,
            'TYPE' => (string)CallType::inboundCall(),
        ])->getExternalCallRegister();

        $finishCallResult = $this->externalCallService->finish([
            'CALL_ID' => $registerCallResult->CALL_ID,
            'USER_ID' => $userId,
            'DURATION' => 10,
            'COST' => 250,
            'COST_CURRENCY' => 'RUB',
            'STATUS_CODE' => StatusSipCodeInterface::STATUS_OK,
            'FAILED_REASON' => '',
            'RECORD_URL' => '',
            'VOTE' => 5,
            'ADD_TO_CHAT' => 1
        ])->getExternalCallFinish();

        $fileName = sprintf('test%s.mp3', time());
        self::assertGreaterThan(1, $this->externalCallService->attachRecord($registerCallResult->CALL_ID, $fileName, $this->getFileInBase64())->getFileId());
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


    private function getFileInBase64(): string
    {
        $filePath = __DIR__ . '/assets/';
        $fileName = 'test-phone-record.mp3';
        $resBase64 = '';
        $handle = fopen($filePath . $fileName, "rb");
        if ($handle) {
            $buffer = fread($handle, filesize($filePath . $fileName));
            $resBase64 = base64_encode($buffer);
        }
        fclose($handle);

        return $resBase64;
    }
}