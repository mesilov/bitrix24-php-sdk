<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Services\CRM\Deal\Service\DealContact;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class DealsTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Deals\Service
 */
class DealContactTest extends TestCase
{
    protected Deal $dealService;
    protected Contact $contactService;
    private DealContact $dealContactService;

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealContact::add
     * @throws BaseException
     * @throws TransportException
     */
    public function testAddWithPrimary(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add(
                $dealId,
                $this->contactService->add(['NAME' => 'test contact'], [])->getId(),
                true
            )->getId()
        );
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealContact::add
     * @throws BaseException
     * @throws TransportException
     */
    public function testAddWithSecondary(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();

        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add($dealId, $this->contactService->add(['NAME' => 'test contact 1'], [])->getId(), true)->getId()
        );
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add($dealId, $this->contactService->add(['NAME' => 'test contact 2'], [])->getId(), false)->getId()
        );
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealContact::itemsGet
     * @throws BaseException
     * @throws TransportException
     */
    public function testItemsGet(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add(
                $dealId,
                $this->contactService->add(['NAME' => 'test contact 1'], [])->getId(),
                true
            )->getId()
        );
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add(
                $dealId,
                $this->contactService->add(['NAME' => 'test contact 2'], [])->getId(),
                false
            )->getId()
        );

        $this::assertCount(2, $this->dealContactService->itemsGet($dealId)->getDealContacts());
    }


    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealContact::itemsDelete
     * @throws BaseException
     * @throws TransportException
     */
    public function testItemsDelete(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add(
                $dealId,
                $this->contactService->add(['NAME' => 'test contact 1'], [])->getId(),
                true
            )->getId()
        );
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add(
                $dealId,
                $this->contactService->add(['NAME' => 'test contact 2'], [])->getId(),
                false
            )->getId()
        );
        $this::assertCount(2, $this->dealContactService->itemsGet($dealId)->getDealContacts());
        $this::assertTrue($this->dealContactService->itemsDelete($dealId)->isSuccess());
        $this::assertCount(0, $this->dealContactService->itemsGet($dealId)->getDealContacts());
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealContact::itemsSet
     * @throws BaseException
     * @throws TransportException
     */
    public function testItemsSet(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $contact1Id = $this->contactService->add(['NAME' => 'test contact 1'], [])->getId();
        $contact2Id = $this->contactService->add(['NAME' => 'test contact 2'], [])->getId();

        $sort = 400;

        $this::assertTrue(
            $this->dealContactService->itemsSet(
                $dealId,
                [
                    [
                        'CONTACT_ID' => $contact2Id,
                        'SORT'       => $sort,
                        'IS_PRIMARY' => 'Y',
                    ],
                    [
                        'CONTACT_ID' => $contact1Id,
                        'SORT'       => '100',
                        'IS_PRIMARY' => 'N',
                    ],
                ]

            )->isSuccess()
        );

        $this::assertCount(2, $this->dealContactService->itemsGet($dealId)->getDealContacts());
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealContact::delete
     * @throws BaseException
     * @throws TransportException
     */
    public function testDelete(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $contact1Id = $this->contactService->add(['NAME' => 'test contact 1'], [])->getId();
        $contact2Id = $this->contactService->add(['NAME' => 'test contact 2'], [])->getId();

        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add($dealId, $contact1Id, true)->getId()
        );
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealContactService->add($dealId, $contact2Id, false)->getId()
        );

        $this::assertCount(2, $this->dealContactService->itemsGet($dealId)->getDealContacts());

        $this::assertTrue($this->dealContactService->delete($dealId, $contact2Id)->isSuccess());

        $this::assertCount(1, $this->dealContactService->itemsGet($dealId)->getDealContacts());
    }

    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
        $this->dealContactService = Fabric::getServiceBuilder()->getCRMScope()->dealContact();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }
}