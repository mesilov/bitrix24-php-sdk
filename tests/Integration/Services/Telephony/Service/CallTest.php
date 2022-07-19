<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Lead\Service\Lead;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\CurrencyList;
use Bitrix24\SDK\Services\Telephony\Common\StatusSipCodeInterface;
use Bitrix24\SDK\Services\Telephony\Service\Call;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;
use Bitrix24\SDK\Tests\Integration\Fabric;
use DateTime;
use DateTimeInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class CallTest extends TestCase
{
    protected Call $callService;
    protected Lead $leadService;
    protected ExternalCall $externalCallService;
    protected Main $mainService;


    /**
     * @throws BaseException
     * @throws TransportException
     * @throws Exception
     * @covers ExternalCall::attachTranscription
     */

    public function testAttachTranscription():void
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

        $messages = [
            [
                'SIDE'=>'User',
                'START_TIME'=>1,
                'STOP_TIME'=>3,
                'MESSAGE'=>'HELLO WORLD'
            ],
            [
                'SIDE'=> "Client",
                'START_TIME'=>4,
                'STOP_TIME'=>8,
                'MESSAGE'=>"Здравствуйте, вы продаете пылесосы?"
            ],
            [
                'SIDE'=>'User',
                'START_TIME'=>1,
                'STOP_TIME'=>3,
                'MESSAGE'=>'HELLO WORLD'
            ],
            [
                'SIDE'=> "Client",
                'START_TIME'=>4,
                'STOP_TIME'=>8,
                'MESSAGE'=>"Здравствуйте, вы продаете пылесосы?"
            ]
        ];
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
            'TYPE' => (string)CallType::outboundCall(),
        ])->getExternalCallRegister();

        $finishCallResult = $this->externalCallService->finish([
            'CALL_ID' => $registerCallResult->CALL_ID,
            'USER_ID' => $userId,
            'DURATION' => 255,
            'COST' => 250,
            'COST_CURRENCY' => (string)CurrencyList::rub(),
            'STATUS_CODE' => StatusSipCodeInterface::STATUS_OK,
            'FAILED_REASON' => '',
            'RECORD_URL' => '',
            'VOTE' => 5,
            'ADD_TO_CHAT' => 1
        ])->getExternalCallFinish();

        $TranscriptionResult = $this->callService->attachTranscription($registerCallResult->CALL_ID, 50, (string)CurrencyList::rub(), $messages)->getCallTranscription();
        if ($messages[0]['SIDE'] === 'User'){
            self::assertEquals('User', $messages[0]['SIDE']);
        }
        self::assertGreaterThan(1,$TranscriptionResult);
        self::assertNotEmpty($messages);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->callService = Fabric::getServiceBuilder()->getTelephonyScope()->call();
        $this->externalCallService = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
    }

}