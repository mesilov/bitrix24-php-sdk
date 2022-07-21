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
use Bitrix24\SDK\Services\Telephony\Common\CurrencyList;
use Bitrix24\SDK\Services\Telephony\Common\StatusSipCodeInterface;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;
use Bitrix24\SDK\Tests\Integration\Fabric;
use DateTime;
use DateTimeInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class SearchCrmEntitiesTest extends TestCase
{

    protected Lead $leadService;
    protected ExternalCall $externalCallService;
    protected Contact $contactService;

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::searchCrmEntities
     */
    public function testSearchCrmEntities(): void
    {
        //Не зарегистрированный телефон
        $unusedPhone = '+51045005010';
        $infoAboutNotExistingCustomerResult = $this->externalCallService->searchCrmEntities($unusedPhone)->getCrmEntities();
        self::assertEmpty($infoAboutNotExistingCustomerResult,sprintf('No customers can be found for this number: %s',$unusedPhone));

        //Зарегистрированный контакт
        $phoneNumberClient1 = sprintf('+7%s', time());
        $contactId1 = $this->contactService->add(
            [
                'NAME' => 'Глеб',
                'SECOND_NAME' => 'Егорович',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumberClient1,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $infoAboutClientResult1 = $this->externalCallService->searchCrmEntities($phoneNumberClient1)->getCrmEntities();
        self::assertNotEmpty($infoAboutClientResult1);
        $entityType = $infoAboutClientResult1[0]['CRM_ENTITY_TYPE'];
        self::assertEquals('CONTACT', $entityType, sprintf('name type incorrect, expected: CONTACT , and your type: %s', $entityType));
        $this->contactService->delete($contactId1)->isSuccess();

        //Зарегистрированный лид
        $phoneNumberLead1 = sprintf('+7%s', time());
        $leadId1 = $this->leadService->add(
            [
                'TITLE' => 'ИП Титов',
                'NAME' => 'Кирилл',
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumberLead1,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $infoAboutLeadResult = $this->externalCallService->searchCrmEntities($phoneNumberLead1)->getCrmEntities();
        self::assertNotEmpty($infoAboutLeadResult);
        $entityType = $infoAboutLeadResult[0]['CRM_ENTITY_TYPE'];
        self::assertEquals('LEAD', $entityType, sprintf('name type incorrect, expected: LEAD , and your type: %s', $entityType));
        $this->leadService->delete($leadId1);


        $onePhoneTwoContact = sprintf('+7%s', time());
        $contactId2 = $this->contactService->add(
            [
                'NAME' => 'Глеб',
                'SECOND_NAME' => 'Егорович',
                'PHONE' => [
                    [
                        'VALUE' => $onePhoneTwoContact,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $contactId3 = $this->contactService->add(
            [
                'NAME' => 'Хлеб',
                'SECOND_NAME' => 'Олегович',
                'PHONE' => [
                    [
                        'VALUE' => $onePhoneTwoContact,
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ]
        )->getId();
        $infoAboutTwoContactResult = $this->externalCallService->searchCrmEntities($onePhoneTwoContact)->getCrmEntities();
        var_dump($infoAboutTwoContactResult);
        self::assertNotEmpty($infoAboutTwoContactResult);
        $entityTypeContact1 = $infoAboutLeadResult[0]['CRM_ENTITY_TYPE'];
                           $entityTypeContact2 = $infoAboutLeadResult[1]['CRM_ENTITY_TYPE'];
        self::assertEquals('CONTACT', $entityTypeContact1, sprintf('name type incorrect, expected: CONTACT , and your type: %s', $entityTypeContact1));
        self::assertEquals('CONTACT', $entityTypeContact2, sprintf('name type incorrect, expected: CONTACT , and your type: %s', $entityTypeContact2));
        $this->contactService->delete($contactId2);
        $this->contactService->delete($contactId3);

    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public
    function setUp(): void
    {
        $this->externalCallService = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }

}