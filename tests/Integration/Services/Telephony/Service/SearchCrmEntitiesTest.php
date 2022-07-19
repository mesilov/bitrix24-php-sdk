<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\CRM\Lead\Service\Lead;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\CurrencyList;
use Bitrix24\SDK\Services\Telephony\Common\StatusSipCodeInterface;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;
use Bitrix24\SDK\Tests\Integration\Fabric;
use DateTime;
use DateTimeInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class SearchCrmEntitiesTest extends TestCase{

    protected Lead $leadService;
    protected ExternalCall $externalCallService;
    private Main $mainService;
    protected Contact $contactService;

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::searchCrmEntities
     */
    public function testSearchCrmEntities():void
    {
        $unusedPhone = sprintf('+8%s', time());
        $datetime = new DateTime('now');
        $callStartDate = $datetime->format(DateTimeInterface::ATOM);
        $phoneNumber = sprintf('+7%s', time());
        $contactId = $this->contactService->add(
            [
                'TITLE' => 'test contact',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumber,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
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
            'CRM_ENTITY_ID' => $contactId,
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
            'COST_CURRENCY' => (string)CurrencyList::rub(),
            'STATUS_CODE' => StatusSipCodeInterface::STATUS_OK,
            'FAILED_REASON' => '',
            'RECORD_URL' => '',
            'VOTE' => 5,
            'ADD_TO_CHAT' => 1
        ])->getExternalCallFinish();

        $infoAboutClientThatIsNot = $this->externalCallService->searchCrmEntities($unusedPhone)->getCrmEntitiesClient();
        self::assertEmpty($infoAboutClientThatIsNot);

        $infoAboutClientLeadResult = $this->externalCallService->searchCrmEntities($phoneNumber)->getCrmEntitiesClient();
        self::assertNotEmpty($infoAboutClientLeadResult);
        $typeName = $infoAboutClientLeadResult[0]['CRM_ENTITY_TYPE'];
        self::assertEquals('CONTACT',$typeName,sprintf('name type incorrect, expected: CONTACT , and your type: %s',$typeName));
        //self::assertEquals('LEAD',$typeName,sprintf('name type incorrect, expected: LEAD , and your type: %s',$typeName));
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalCallService = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }

}