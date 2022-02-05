<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class DealsTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Deals\Service
 */
class DealTest extends TestCase
{
    protected Deal $dealService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::add
     */
    public function testAdd(): void
    {
        self::assertGreaterThan(1, $this->dealService->add(['TITLE' => 'test deal'])->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::delete
     */
    public function testDelete(): void
    {
        self::assertTrue($this->dealService->delete($this->dealService->add(['TITLE' => 'test deal'])->getId())->isSuccess());
    }

    /**
     * @covers Deal::fields
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        self::assertIsArray($this->dealService->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::get
     */
    public function testGet(): void
    {
        self::assertGreaterThan(
            1,
            $this->dealService->get($this->dealService->add(['TITLE' => 'test deal'])->getId())->deal()->ID
        );
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::list
     */
    public function testList(): void
    {
        $this->dealService->add(['TITLE' => 'test']);
        self::assertGreaterThanOrEqual(1, $this->dealService->list([], [], ['ID', 'TITLE', 'TYPE_ID'])->getDeals());
    }

    public function testUpdate(): void
    {
        $deal = $this->dealService->add(['TITLE' => 'test']);
        $newTitle = 'test2';

        self::assertTrue($this->dealService->update($deal->getId(), ['TITLE' => $newTitle], [])->isSuccess());
        self::assertEquals($newTitle, $this->dealService->get($deal->getId())->deal()->TITLE);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\Deal::countByFilter
     */
    public function testCountByFilter(): void
    {
        $before = $this->dealService->countByFilter();

        $newDealsCount = 60;
        $deals = [];
        for ($i = 1; $i <= $newDealsCount; $i++) {
            $deals[] = ['TITLE' => 'TITLE-' . $i];
        }
        $cnt = 0;
        foreach ($this->dealService->batch->add($deals) as $item) {
            $cnt++;
        }
        self::assertEquals(count($deals), $cnt);

        $after = $this->dealService->countByFilter();

        $this->assertEquals($before + $newDealsCount, $after);
    }

    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
    }
}