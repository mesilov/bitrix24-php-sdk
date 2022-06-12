<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Activity\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Activity\Service\Activity;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{
    private Activity $activityService;
    private Contact $contactService;
    private array $contactId;
    private array $activityId;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Activity\Service\Activity::add
     */
    public function testAdd(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;
        $this->activityId[] = $this->activityService->add(
            [
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
            ]
        )->getId();
        // successfully add activity
        $this->assertTrue(true);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Activity\Service\Activity::delete
     */
    public function testDelete(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;
        $activityId = $this->activityService->add(
            [
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
            ]
        )->getId();
        $this->assertTrue($this->activityService->delete($activityId)->isSuccess());
    }

    /**
     * @covers Contact::fields
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        self::assertIsArray($this->activityService->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Activity\Service\Activity::get
     */
    public function testGet(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;

        $newActivity = [
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
        $activityId = $this->activityService->add($newActivity)->getId();
        $this->activityId[] = $activityId;

        $activity = $this->activityService->get($activityId)->activity();

        $this->assertEquals($newActivity['OWNER_ID'], $activity->OWNER_ID);
        $this->assertEquals($newActivity['SUBJECT'], $activity->SUBJECT);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Activity\Service\Activity::list
     */
    public function testList(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;

        $newActivity = [];
        for ($i = 1; $i < 10; $i++) {
            $newActivity[$i] = [
                'OWNER_ID'         => $contactId,
                'OWNER_TYPE_ID'    => 3,
                'TYPE_ID'          => 2,
                'PROVIDER_ID'      => 'VOXIMPLANT_CALL',
                'PROVIDER_TYPE_ID' => 'CALL',
                'SUBJECT'          => sprintf('test activity - %s', $i),
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
            $this->activityId[] = $this->activityService->add($newActivity[$i])->getId();;
        }

        $res = $this->activityService->list(
            ['ID' => 'DESC'],
            [
                'OWNER_ID' => $contactId,
            ],
            ["*", "COMMUNICATIONS"],
            0
        );
        $this->assertEquals(count($newActivity), count($res->getActivities()));
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Activity\Service\Activity::update
     */
    public function testUpdate(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;

        $newActivity = [
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
        $activityId = $this->activityService->add($newActivity)->getId();
        $this->activityId[] = $activityId;

        $subject = 'qqqqq';
        $this->activityService->update($activityId, [
            'SUBJECT' => $subject,
        ]);

        $this->assertEquals($subject, $this->activityService->get($activityId)->activity()->SUBJECT);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testCountByFilter(): void
    {
        $contactId = $this->contactService->add(['NAME' => 'test contact'])->getId();
        $this->contactId[] = $contactId;

        $newActivity = [];
        for ($i = 1; $i < 10; $i++) {
            $newActivity[$i] = [
                'OWNER_ID'         => $contactId,
                'OWNER_TYPE_ID'    => 3,
                'TYPE_ID'          => 2,
                'PROVIDER_ID'      => 'VOXIMPLANT_CALL',
                'PROVIDER_TYPE_ID' => 'CALL',
                'SUBJECT'          => sprintf('test activity - %s', $i),
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
            $this->activityId[] = $this->activityService->add($newActivity[$i])->getId();;
        }

        $this->assertEquals(
            count($newActivity),
            $this->activityService->countByFilter(
                [
                    'OWNER_ID' => $contactId,
                ]
            )
        );
    }

    public function tearDown(): void
    {
        foreach ($this->activityService->batch->delete($this->activityId) as $result) {
        }
        foreach ($this->contactService->batch->delete($this->contactId) as $result) {
        }
    }

    public function setUp(): void
    {
        $this->activityService = Fabric::getServiceBuilder()->getCRMScope()->activity();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
        $this->contactId = [];
        $this->activityId = [];
    }
}