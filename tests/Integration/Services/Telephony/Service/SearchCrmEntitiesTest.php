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
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Exception;
use PHPUnit\Framework\TestCase;

class SearchCrmEntitiesTest extends TestCase
{

    protected Lead $leadService;
    protected ExternalCall $externalCallService;
    protected Contact $contactService;

    /**
     * @throws Exception
     * @covers ExternalCall::searchCrmEntities
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testSearchCrmEntitiesWithEmptyResult(): void
    {
        //Не зарегистрированный телефон
        $unusedPhone = '+51045005010';
        $infoAboutNotExistingCustomerResult = $this->externalCallService->searchCrmEntities($unusedPhone)->getCrmEntitiesSearchResult();
        self::assertEmpty($infoAboutNotExistingCustomerResult, sprintf('No customers can be found for this number: %s', $unusedPhone));
    }

    /**
     * @throws Exception
     * @covers ExternalCall::searchCrmEntities
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testSearchCrmEntitiesContactFound(): void
    {
        //Зарегистрированный контакт
        $phoneNumberClient = sprintf('+7%s%s', time(), random_int(1, PHP_INT_MAX));
        $contactId = $this->contactService->add(
            [
                'NAME'        => 'Глеб',
                'SECOND_NAME' => 'Егорович',
                'PHONE'       => [
                    [
                        'VALUE'      => $phoneNumberClient,
                        'VALUE_TYPE' => 'WORK',
                    ],
                ],
            ]
        )->getId();
        $infoAboutClientResult = $this->externalCallService->searchCrmEntities($phoneNumberClient)->getCrmEntitiesSearchResult();
        $this->assertCount(1, $infoAboutClientResult);

        self::assertEquals(
            'CONTACT',
            $infoAboutClientResult[0]->CRM_ENTITY_TYPE,
            sprintf(
                'name type incorrect, expected: CONTACT , and your type: %s',
                $infoAboutClientResult[0]->CRM_ENTITY_TYPE
            )
        );

        $this->assertEquals($contactId, $infoAboutClientResult[0]->CRM_ENTITY_ID);

        $this->contactService->delete($contactId);
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::searchCrmEntities
     */
    public function testSearchCrmEntitiesLeadFound(): void
    {
        //Зарегистрированный лид
        $phoneNumberLead = sprintf('+7%s%s', time(), random_int(1, PHP_INT_MAX));
        $leadId1 = $this->leadService->add(
            [
                'TITLE' => 'ИП Титов',
                'NAME'  => 'Кирилл',
                'PHONE' => [
                    [
                        'VALUE'      => $phoneNumberLead,
                        'VALUE_TYPE' => 'WORK',
                    ],
                ],
            ]
        )->getId();
        $infoAboutLeadResult = $this->externalCallService->searchCrmEntities($phoneNumberLead)->getCrmEntitiesSearchResult();
        $this->assertCount(1, $infoAboutLeadResult);

        self::assertEquals(
            'LEAD',
            $infoAboutLeadResult[0]->CRM_ENTITY_TYPE,
            sprintf('name type incorrect, expected: LEAD , and your type: %s', $infoAboutLeadResult[0]->CRM_ENTITY_TYPE)
        );
        $this->leadService->delete($leadId1);
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws Exception
     * @covers ExternalCall::searchCrmEntities
     */
    public function testSearchCrmEntitiesMultipleContactsFound(): void
    {
        $contactPhone = sprintf('+7%s%s', time(), random_int(1, PHP_INT_MAX));
        $contactId1 = $this->contactService->add(
            [
                'NAME'        => 'Глеб',
                'SECOND_NAME' => 'Егорович',
                'PHONE'       => [
                    [
                        'VALUE'      => $contactPhone,
                        'VALUE_TYPE' => 'WORK',
                    ],
                ],
            ]
        )->getId();
        $contactId2 = $this->contactService->add(
            [
                'NAME'        => 'Хлеб',
                'SECOND_NAME' => 'Олегович',
                'PHONE'       => [
                    [
                        'VALUE'      => $contactPhone,
                        'VALUE_TYPE' => 'WORK',
                    ],
                ],
            ]
        )->getId();
        $contactIds = [$contactId1, $contactId2];
        $this->externalCallService->searchCrmEntities($contactPhone)->getCrmEntitiesSearchResult();
        $this->assertTrue(in_array($contactId1, $contactIds, true));
        $this->contactService->delete($contactId1);
        $this->contactService->delete($contactId2);
    }

    /**
     * @throws Exception
     * @covers ExternalCall::searchCrmEntities
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testSearchCrmEntitiesWithDifferentPhonePrefix(): void
    {
        $phoneBody = sprintf('+7%s%s', time(), random_int(1, PHP_INT_MAX));
        $contactPhone1 = sprintf('+7%s', $phoneBody);
        $contactPhone2 = sprintf('+8%s', $phoneBody);
        $contactId1 = $this->contactService->add(
            [
                'NAME'        => 'Глеб',
                'SECOND_NAME' => 'Егорович',
                'PHONE'       => [
                    [
                        'VALUE'      => $contactPhone1,
                        'VALUE_TYPE' => 'WORK',
                    ],
                ],
            ]
        )->getId();

        $infoAboutTwoContactsResult1 = $this->externalCallService->searchCrmEntities($contactPhone1)->getCrmEntitiesSearchResult();
        $infoAboutTwoContactsResult2 = $this->externalCallService->searchCrmEntities($contactPhone2)->getCrmEntitiesSearchResult();
        $infoAboutTwoContactsResult3 = $this->externalCallService->searchCrmEntities($phoneBody)->getCrmEntitiesSearchResult();
        $this->assertEquals($contactId1, $infoAboutTwoContactsResult1[0]->CRM_ENTITY_ID);
        $this->assertEmpty($infoAboutTwoContactsResult2);
        $this->assertEmpty($infoAboutTwoContactsResult3);
        $this->contactService->delete($contactId1);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalCallService = Fabric::getServiceBuilder()->getTelephonyScope()->externalCall();
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }

}