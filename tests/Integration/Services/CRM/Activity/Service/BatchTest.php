<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Activity\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Activity\Service\Activity;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class BatchTest extends TestCase
{
    private Contact $contactService;
    private Activity $activityService;
    private const BATCH_TEST_ELEMENTS_COUNT = 60;
    private array $contactId;

    /**
     * @testdox Batch add deals
     * @covers  \Bitrix24\SDK\Services\CRM\Activity\Service\Batch::add()
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testBatchAdd(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;

        $items = [];
        for ($i = 1; $i < self::BATCH_TEST_ELEMENTS_COUNT; $i++) {
            $items[] = [
                'OWNER_ID'         => $contactId,
                'OWNER_TYPE_ID'    => 3,
                'TYPE_ID'          => 2,
                'PROVIDER_ID'      => 'VOXIMPLANT_CALL',
                'PROVIDER_TYPE_ID' => 'CALL',
                'SUBJECT'          => 'test activity',
                'DESCRIPTION'      => 'test activity description',
                'DESCRIPTION_TYPE' => '1',
                'DIRECTION'        => '2',
                'COMMUNICATIONS'   => [
                    0 => [
                        'TYPE'  => 'PHONE',
                        'VALUE' => '+79780194444',
                    ],
                ],
            ];
        }

        $cnt = 0;
        $activityId = [];
        foreach ($this->activityService->batch->add($items) as $item) {
            $cnt++;
            $activityId[] = $item->getId();
        }
        self::assertEquals(count($items), $cnt);

        $cnt = 0;
        foreach ($this->activityService->batch->delete($activityId) as $cnt => $deleteResult) {
            $cnt++;
        }
        self::assertEquals(count($items), $cnt);
    }

    /**
     * @testdox Batch delete activities
     * @covers  \Bitrix24\SDK\Services\CRM\Activity\Service\Batch::delete()
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testBatchDelete(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;

        $items = [];
        for ($i = 1; $i < self::BATCH_TEST_ELEMENTS_COUNT; $i++) {
            $items[] = [
                'OWNER_ID'         => $contactId,
                'OWNER_TYPE_ID'    => 3,
                'TYPE_ID'          => 2,
                'PROVIDER_ID'      => 'VOXIMPLANT_CALL',
                'PROVIDER_TYPE_ID' => 'CALL',
                'SUBJECT'          => 'test activity',
                'DESCRIPTION'      => 'test activity description',
                'DESCRIPTION_TYPE' => '1',
                'DIRECTION'        => '2',
                'COMMUNICATIONS'   => [
                    0 => [
                        'TYPE'  => 'PHONE',
                        'VALUE' => '+79780194444',
                    ],
                ],
            ];
        }

        $cnt = 0;
        $activityId = [];
        foreach ($this->activityService->batch->add($items) as $item) {
            $cnt++;
            $activityId[] = $item->getId();
        }
        self::assertEquals(count($items), $cnt);

        $cnt = 0;
        foreach ($this->activityService->batch->delete($activityId) as $cnt => $deleteResult) {
            $cnt++;
        }
        self::assertEquals(count($items), $cnt);


        $this->assertEquals(
            0,
            $this->activityService->countByFilter(
                [
                    'OWNER_ID' => $contactId,
                ]
            )
        );
    }

    /**
     * @testdox Batch list deals
     * @covers  \Bitrix24\SDK\Services\CRM\Contact\Service\Batch::list()
     * @throws BaseException
     * @throws TransportException
     */
    public function testBatchList(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;

        $items = [];
        for ($i = 1; $i < self::BATCH_TEST_ELEMENTS_COUNT; $i++) {
            $items[] = [
                'OWNER_ID'         => $contactId,
                'OWNER_TYPE_ID'    => 3,
                'TYPE_ID'          => 2,
                'PROVIDER_ID'      => 'VOXIMPLANT_CALL',
                'PROVIDER_TYPE_ID' => 'CALL',
                'SUBJECT'          => 'test activity',
                'DESCRIPTION'      => 'test activity description',
                'DESCRIPTION_TYPE' => '1',
                'DIRECTION'        => '2',
                'COMMUNICATIONS'   => [
                    0 => [
                        'TYPE'  => 'PHONE',
                        'VALUE' => '+79780194444',
                    ],
                ],
            ];
        }

        $cnt = 0;
        $activityId = [];
        foreach ($this->activityService->batch->add($items) as $item) {
            $cnt++;
            $activityId[] = $item->getId();
        }

        //fetch items
        $itemsCnt = 0;
        foreach ($this->activityService->batch->list(['ID' => 'DESC'], ['OWNER_ID' => $contactId], ['*']) as $item) {
            $itemsCnt++;
        }
        $this->assertEquals(
            count($activityId),
            $itemsCnt,
            sprintf(
                'batch activity list not fetched, expected %s, actual %s',
                count($activityId),
                $itemsCnt
            )
        );
    }

    public function tearDown(): void
    {
        $this->contactService->batch->delete($this->contactId);
    }

    public function setUp(): void
    {
        $this->activityService = Fabric::getServiceBuilder()->getCRMScope()->activity();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
        $this->contactId = [];
    }
}