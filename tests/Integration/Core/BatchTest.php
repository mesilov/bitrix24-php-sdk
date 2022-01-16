<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Core;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class BatchTest extends TestCase
{
    protected Batch $batchService;
    protected ServiceBuilder $serviceBuilder;
    private const DEMO_DATA_ARRAY_SIZE = 125;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @covers  \Bitrix24\SDK\Core\Batch::addEntityItems
     * @testdox Добавление сущностей в batch режиме
     */
    public function testBatchAddCommand(): void
    {
        // prepare demo data
        $contactId = $this->serviceBuilder->getCRMScope()->contact()->add(
            [
                'NAME'   => sprintf('first_%s', time()),
                'SECOND' => sprintf('second_%s', time()),
            ]
        )->getId();
        $rawDeals = [];
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE; $i++) {
            $rawDeals[] = [
                [
                    'fields' => [
                        'TITLE'       => sprintf('deal-%s', $i),
                        'OPPORTUNITY' => random_int(100, 40000),
                        'CONTACT_ID'  => $contactId,
                    ],
                ],
            ];
        }

        // add deals to bitrix24
        $dealIdList = [];
        foreach ($this->batchService->addEntityItems('crm.deal.add', $rawDeals) as $cnt => $addDealResult) {
            $dealIdList[] = $addDealResult->getResult()->getResultData()[0];
        }
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE, $dealIdList);
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @covers  \Bitrix24\SDK\Core\Batch::addEntityItems
     * @covers  \Bitrix24\SDK\Core\Batch::deleteEntityItems
     * @testdox Удаление сущностей в batch режиме
     */
    public function testBatchDeleteCommand(): void
    {
        // prepare demo data
        $contactId = $this->serviceBuilder->getCRMScope()->contact()->add(
            [
                'NAME'   => sprintf('first_%s', time()),
                'SECOND' => sprintf('second_%s', time()),
            ]
        )->getId();
        $rawDeals = [];
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE; $i++) {
            $rawDeals[] = [
                [
                    'fields' => [
                        'TITLE'       => sprintf('deal-%s', $i),
                        'OPPORTUNITY' => random_int(100, 40000),
                        'CONTACT_ID'  => $contactId,
                    ],
                ],
            ];
        }

        // add deals to bitrix24
        $dealIdList = [];
        foreach ($this->batchService->addEntityItems('crm.deal.add', $rawDeals) as $cnt => $addDealResult) {
            $dealIdList[] = $addDealResult->getResult()->getResultData()[0];
        }
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE, $dealIdList);

        // delete deals from bitrix24
        $dealsDeleteResult = [];
        foreach ($this->batchService->deleteEntityItems('crm.deal.delete', $dealIdList) as $cnt => $deleteDealResult) {
            $dealsDeleteResult[] = $deleteDealResult->getResult()->getResultData()[0];
        }
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE, $dealsDeleteResult);
    }

    public function setUp(): void
    {
        $this->batchService = Fabric::getBatchService();
        $this->serviceBuilder = Fabric::getServiceBuilder();
    }

    public function tearDown(): void
    {
    }
}