<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Core\BulkItemsReader\ReadStrategies;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies\FilterWithoutBatchWithoutCountOrder;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class FilterWithoutBatchWithoutCountOrderTest extends TestCase
{
    protected Batch $batch;
    protected ServiceBuilder $serviceBuilder;
    protected LoggerInterface $log;
    protected Stopwatch $stopwatch;
    protected BulkItemsReaderInterface $bulkItemsReader;
    private const DEMO_DATA_ARRAY_SIZE = 151;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @covers  \Bitrix24\SDK\Core\Batch::getTraversableListWithoutCount
     * @testdox Добавление сущностей в batch режиме
     */
    public function testGetTraversableListWithoutCountWithMoreThanPageSizeFilterResult(): void
    {
        // prepare demo data
        $contactId = $this->serviceBuilder->getCRMScope()->contact()->add(
            [
                'NAME'   => sprintf('first_%s', time()),
                'SECOND' => sprintf('second_%s', time()),
            ]
        )->getId();

        // add deals to bitrix24
        $rawDeals = [];
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE; $i++) {
            $rawDeals[] = [
                'TITLE'                 => sprintf('deal-%s', $i),
                'IS_MANUAL_OPPORTUNITY' => 'Y',
                'OPPORTUNITY'           => sprintf('%s.00', random_int(100, 40000)),
                'CURRENCY_ID'           => 'RUB',
                'CONTACT_ID'            => $contactId,
            ];
        }
        $dealIdList = [];
        foreach ($this->serviceBuilder->getCRMScope()->deal()->batch->add($rawDeals) as $addDealResult) {
            $dealIdList[] = $addDealResult->getId();
        }
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE, $dealIdList);

        // count added deals by default deal service
        $filter = [
            'CONTACT_ID' => $contactId,
        ];

        $elementsCountByFilter = $this->serviceBuilder->getCRMScope()->deal()->countByFilter($filter);
        $this->assertEquals(self::DEMO_DATA_ARRAY_SIZE, $elementsCountByFilter);

        $select = [
            'ID',
            'TITLE',
            'OPPORTUNITY',
        ];

        $elementsCount = 0;
        $this->stopwatch->start('batch.list.with.count');
        foreach ($this->batch->getTraversableList('crm.deal.list', [], $filter, $select) as $cnt => $dealItem) {
            $elementsCount++;
//            print(sprintf(
//                    '%s-%s| %s | %s - %s',
//                    $cnt,
//                    $elementsCountByFilter,
//                    $dealItem['ID'],
//                    $dealItem['TITLE'],
//                    $dealItem['OPPORTUNITY'],
//                ) . PHP_EOL);
        }
        $this->stopwatch->stop('batch.list.with.count');
        $this->assertEquals(
            $elementsCountByFilter,
            $elementsCount,
            sprintf(
                'elements count by filter %s not equals elements count from batch %s',
                $elementsCountByFilter,
                $elementsCount
            )
        );


        $elementsCount = 0;
        $this->stopwatch->start('FilterWithoutBatchWithoutCountOrder');
        foreach (
            $this->bulkItemsReader->getTraversableList(
                'crm.deal.list',
                ['ID' => 'ASC'],
                $filter,
                $select
            ) as $cnt => $dealItem
        ) {
            $elementsCount++;
//            print(sprintf(
//                    '%s-%s| %s | %s - %s',
//                    $cnt,
//                    $elementsCountByFilter,
//                    $dealItem['ID'],
//                    $dealItem['TITLE'],
//                    $dealItem['OPPORTUNITY'],
//                ) . PHP_EOL);
        }
        $this->stopwatch->stop('FilterWithoutBatchWithoutCountOrder');
        $this->assertEquals(
            $elementsCountByFilter,
            $elementsCount,
            sprintf(
                'elements count by filter %s not equals elements count from batch %s',
                $elementsCountByFilter,
                $elementsCount
            )
        );

        print('=====' . PHP_EOL);
        print(sprintf(
                'duration for batch list with count: %s ms',
                $this->stopwatch->getEvent('batch.list.with.count')->getDuration()
            ) . PHP_EOL);
        print(sprintf(
                'FilterWithoutBatchWithoutCountOrder: %s ms',
                $this->stopwatch->getEvent('FilterWithoutBatchWithoutCountOrder')->getDuration()
            ) . PHP_EOL);

        $this->assertTrue(true);
    }

    public function setUp(): void
    {
        $this->stopwatch = new Stopwatch(true);
        $this->batch = Fabric::getBatchService();
        $this->serviceBuilder = Fabric::getServiceBuilder();
        $this->log = Fabric::getLogger();
        $this->bulkItemsReader = new FilterWithoutBatchWithoutCountOrder(
            Fabric::getCore(),
            $this->log
        );
    }

    public function tearDown(): void
    {
    }
}