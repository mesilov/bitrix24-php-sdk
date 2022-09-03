<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Lead\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Lead\Service\Lead;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Lead\Service
 */
class LeadTest extends TestCase
{
    protected Lead $leadService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Lead::add
     */
    public function testAdd(): void
    {
        self::assertGreaterThan(1, $this->leadService->add(['TITLE' => 'test lead'])->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Lead::delete
     */
    public function testDelete(): void
    {
        self::assertTrue($this->leadService->delete($this->leadService->add(['TITLE' => 'test lead'])->getId())->isSuccess());
    }

    /**
     * @covers Lead::fields
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        self::assertIsArray($this->leadService->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Lead::get
     */
    public function testGet(): void
    {
        self::assertGreaterThan(
            1,
            $this->leadService->get($this->leadService->add(['TITLE' => 'test Lead'])->getId())->lead()->ID
        );
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Lead::list
     */
    public function testList(): void
    {
        $this->leadService->add(['TITLE' => 'test']);
        self::assertGreaterThanOrEqual(1, $this->leadService->list([], [], ['ID', 'TITLE'])->getLeads());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Lead::update
     */
    public function testUpdate(): void
    {
        $deal = $this->leadService->add(['TITLE' => 'test lead']);
        $newTitle = 'test2';

        self::assertTrue($this->leadService->update($deal->getId(), ['TITLE' => $newTitle], [])->isSuccess());
        self::assertEquals($newTitle, $this->leadService->get($deal->getId())->lead()->TITLE);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\Deal::countByFilter
     */
    public function testCountByFilter(): void
    {
        $before = $this->leadService->countByFilter();

        $newItemsCount = 60;
        $items = [];
        for ($i = 1; $i <= $newItemsCount; $i++) {
            $items[] = ['TITLE' => 'TITLE-' . $i];
        }
        $cnt = 0;
        foreach ($this->leadService->batch->add($items) as $item) {
            $cnt++;
        }
        self::assertEquals(count($items), $cnt);

        $after = $this->leadService->countByFilter();

        $this->assertEquals($before + $newItemsCount, $after);
    }

    public function setUp(): void
    {
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
    }
}