<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\OperatingTimingTest;
use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
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
    protected Batch $batch;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testOperatingTiming(): void
    {

        $cnt = 0;
        $contactsToUpdate = [];
        foreach ($this->contactService->batch->list([], ['>ID' => '103595'], ['ID','PHONE'], 30000) as $contactList) {
            $cnt++;
            $contactsToUpdate[$contactList->ID] = [
                'fields' => [
                    'PHONE' => [['ID' =>$contactList->PHONE[0]['ID']]]
                ],
                'params' => [],
            ];
            $contactListId[] = $contactList->ID;
        }
        foreach ($this->contactService->batch->update($contactsToUpdate) as $dealUpdateResult) {
            $this->assertTrue($dealUpdateResult->isSuccess());
        }

        self::assertGreaterThanOrEqual(5, $contactListId);

    }

    public function setUp(): void
    {
        $this->batch = Fabric::getBatchService();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }
}