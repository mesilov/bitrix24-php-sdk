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
class BatchTest extends TestCase
{
    protected Deal $dealService;

    /**
     * @testdox Batch list deals
     * @covers  \Bitrix24\SDK\Services\CRM\Contact\Service\Batch::list()
     * @throws BaseException
     * @throws TransportException
     */
    public function testBatchList(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $cnt = 0;

        foreach ($this->dealService->batch->list([], ['ID' => $dealId], ['ID', 'NAME'], 1) as $item) {
            $cnt++;
        }
        self::assertGreaterThanOrEqual(1, $cnt);

        $this->dealService->delete($dealId);
    }

    /**
     * @testdox Batch add deals
     * @covers  \Bitrix24\SDK\Services\CRM\Deal\Service\Batch::add()
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testBatchAdd(): void
    {
        $deals = [];
        for ($i = 1; $i < 60; $i++) {
            $deals[] = ['TITLE' => 'TITLE-' . $i];
        }
        $cnt = 0;
        $dealId = [];
        foreach ($this->dealService->batch->add($deals) as $item) {
            $cnt++;
            $dealId[] = $item->getId();
        }
        self::assertEquals(count($deals), $cnt);

        $cnt = 0;
        foreach ($this->dealService->batch->delete($dealId) as $cnt => $deleteResult) {
            $cnt++;
        }
        self::assertEquals(count($deals), $cnt);
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
        foreach ($this->dealService->batch->add($deals) as $item) {
            $cnt++;
            $dealId[] = $item->getId();
        }
        self::assertEquals(count($deals), $cnt);

        $cnt = 0;
        foreach ($this->dealService->batch->delete($dealId) as $cnt => $deleteResult) {
            $cnt++;
        }
        self::assertEquals(count($deals), $cnt);
    }

    /**
     * @testdox Batch delete deals
     * @covers  \Bitrix24\SDK\Services\CRM\Deal\Service\Batch::update()
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Exception
     */
    public function testBatchUpdate(): void
    {
        // add deals
        $deals = [];
        for ($i = 1; $i < 60; $i++) {
            $deals[] = ['TITLE' => 'TITLE-' . $i];
        }
        $cnt = 0;
        $dealId = [];
        foreach ($this->dealService->batch->add($deals) as $item) {
            $cnt++;
            $dealId[] = $item->getId();
        }
        self::assertEquals(count($deals), $cnt);

        // read deals and prepare update information
        $dealsToUpdate = [];
        $resultDeals = [];
        foreach ($this->dealService->batch->list([], ['ID' => $dealId], ['ID', 'TITLE', 'OPPORTUNITY']) as $deal) {
            $dealOpportunity = random_int(100, 10000);
            $dealsToUpdate[$deal->ID] = [
                'fields' => [
                    'OPPORTUNITY' => $dealOpportunity,
                ],
                'params' => [],
            ];
            $resultDeals[$deal->ID] = $dealOpportunity;
        }

        // update deals
        foreach ($this->dealService->batch->update($dealsToUpdate) as $dealUpdateResult) {
            $this->assertTrue($dealUpdateResult->isSuccess());
        }

        // list deals
        $updateResult = [];
        foreach ($this->dealService->batch->list([], ['ID' => $dealId], ['ID', 'TITLE', 'OPPORTUNITY']) as $deal) {
            $updateResult[$deal->ID] = $deal->OPPORTUNITY;
        }

        $this->assertEquals($resultDeals, $updateResult);
    }

    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
    }
}