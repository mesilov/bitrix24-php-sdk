<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\OperatingTimingTest;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class OperatingTimingTest
 *
 * @package Bitrix24\SDK\Tests\Integration\OperatingTimingTest
 */
class OperatingTimingTest extends TestCase
{
    protected Contact $contactService;
    private Batch $batch;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testOperatingTiming(): void
    {
        $masContacts = [];
        for ($i = 0; $i < 5; $i++) {
            $phoneNumberWork = sprintf('+7%s', time());
            $phoneNumberHome = sprintf('%s', microtime());
            $phoneNumberHome = implode("-", str_split(substr($phoneNumberHome, 2, -13), 2));
            $masContacts[] = [
                'fields' => [
                    'NAME' => sprintf('first_%s', time()),
                    'SECOND' => sprintf('second_%s', time()),
                    'PHONE' => [
                        [
                            'VALUE' => $phoneNumberWork,
                            'VALUE_TYPE' => 'WORK'
                        ],
                        [
                            'VALUE' => $phoneNumberHome,
                            'VALUE_TYPE' => 'HOME'
                        ]
                    ],
                ]
            ];

        }
        $contactsIdList = [];
        foreach ($this->batch->addEntityItems('crm.contact.add', $masContacts) as $addContactResult) {
            $contactsIdList[] = $addContactResult->getResult();
        }
        foreach ($contactsIdList as $contactId) {
            $contactPhoneId = $this->contactService->get($contactId[0])->contact()->PHONE[0]['ID'];
            $contactUpdate = $this->contactService->update((int)$contactId[0],['PHONE' => [['ID' => $contactPhoneId, 'VALUE' => ""]]],[ "REGISTER_SONET_EVENT" => "Y"]);
        }
        $this->assertCount(5, $contactsIdList);
    }

    public function setUp(): void
    {
        $this->batch = Fabric::getBatchService();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }
}