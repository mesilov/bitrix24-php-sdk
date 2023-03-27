<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Contact\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Tests\Builders\Services\CRM\PhoneCollectionBuilder;
use Bitrix24\SDK\Tests\Builders\Services\CRM\PhoneNumberBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Contact\Service
 */
class ContactBatchTest extends TestCase
{
    private const TEST_SEGMENT_ELEMENTS_COUNT = 400;

    protected Contact $contactService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Contact\Service\Batch::list()
     */
    public function testBatchList(): void
    {
        $this->contactService->add(['NAME' => 'test contact']);
        $cnt = 0;

        foreach ($this->contactService->batch->list([], ['>ID' => '1'], ['ID', 'NAME'], 1) as $item) {
            $cnt++;
        }
        self::assertGreaterThanOrEqual(1, $cnt);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Contact\Service\Batch::add()
     */
    public function testBatchAdd(): void
    {
        $contacts = [];
        for ($i = 1; $i < 60; $i++) {
            $contacts[] = ['NAME' => 'name-' . $i];
        }
        $cnt = 0;
        foreach ($this->contactService->batch->add($contacts) as $item) {
            $cnt++;
        }

        self::assertEquals(count($contacts), $cnt);
    }

    /**
     * @return void
     * @throws BaseException
     * @covers \Bitrix24\SDK\Services\CRM\Contact\Service\Batch::update()
     */
    public function testBatchUpdate(): void
    {
        // add contacts
        $contacts = [];
        for ($i = 1; $i <= self::TEST_SEGMENT_ELEMENTS_COUNT; $i++) {
            $contacts[] = [
                'NAME' => 'name-' . time(),
                'SECOND_NAME' => 'second_name-' . time(),
                'LAST_NAME' => 'last_name-' . time(),
                'PHONE' => [
                    [
                        'VALUE' => (new PhoneNumberBuilder())->build(),
                        'VALUE_TYPE' => 'WORK'
                    ]
                ]
            ];
        }
        $cnt = 0;
        $contactId = [];
        foreach ($this->contactService->batch->add($contacts) as $item) {
            $cnt++;
            $contactId[] = $item->getId();
        }
        self::assertEquals(count($contacts), $cnt);

        // generate update data
        $updateContactData = [];
        foreach ($contactId as $id) {
            $updateContactData[$id] = [
                'fields' => [
                    'NAME' => 'name-' . $id . '-updated'
                ],
            ];
        }

        // update contacts in batch mode
        $cnt = 0;
        foreach ($this->contactService->batch->update($updateContactData) as $item) {
            $cnt++;
            $this->assertTrue($item->isSuccess());
        }
        self::assertEquals(count($contacts), $cnt);

        // delete contacts
        $cnt = 0;
        foreach ($this->contactService->batch->delete($contactId) as $item) {
            $cnt++;
            $this->assertTrue($item->isSuccess());
        }
        self::assertEquals(count($contacts), $cnt);
    }

    public function setUp(): void
    {
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }
}
