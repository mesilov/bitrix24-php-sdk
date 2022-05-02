<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Lead\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Lead\Service\Lead;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class BatchTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Lead\Service
 */
class BatchTest extends TestCase
{
    protected Lead $leadService;

    /**
     * @testdox Batch list leads
     * @covers  \Bitrix24\SDK\Services\CRM\Lead\Service\Batch::list()
     * @throws BaseException
     * @throws TransportException
     */
    public function testBatchList(): void
    {
        $itemId = $this->leadService->add(['TITLE' => 'test lead'])->getId();
        $cnt = 0;

        foreach ($this->leadService->batch->list([], ['ID' => $itemId], ['ID', 'NAME'], 1) as $item) {
            $cnt++;
        }
        self::assertGreaterThanOrEqual(1, $cnt);

        $this->leadService->delete($itemId);
    }

    /**
     * @testdox Batch add lead
     * @covers  \Bitrix24\SDK\Services\CRM\Lead\Service\Batch::add()
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testBatchAdd(): void
    {
        $items = [];
        for ($i = 1; $i < 60; $i++) {
            $items[] = ['TITLE' => 'TITLE-' . $i];
        }
        $cnt = 0;
        $itemId = [];
        foreach ($this->leadService->batch->add($items) as $item) {
            $cnt++;
            $itemId[] = $item->getId();
        }
        self::assertEquals(count($items), $cnt);

        $cnt = 0;
        foreach ($this->leadService->batch->delete($itemId) as $cnt => $deleteResult) {
            $cnt++;
        }
        self::assertEquals(count($items), $cnt);
    }

    /**
     * @testdox Batch delete deals
     * @covers  \Bitrix24\SDK\Services\CRM\Deal\Service\Batch::add()
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testBatchDelete(): void
    {
        $deals = [];
        for ($i = 1; $i < 60; $i++) {
            $deals[] = ['TITLE' => 'TITLE-' . $i];
        }
        $cnt = 0;
        $dealId = [];
        foreach ($this->leadService->batch->add($deals) as $item) {
            $cnt++;
            $dealId[] = $item->getId();
        }
        self::assertEquals(count($deals), $cnt);

        $cnt = 0;
        foreach ($this->leadService->batch->delete($dealId) as $cnt => $deleteResult) {
            $cnt++;
        }
        self::assertEquals(count($deals), $cnt);
    }

    public function setUp(): void
    {
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
    }
}