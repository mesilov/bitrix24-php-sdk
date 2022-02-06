<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Core\BulkItemsReader\ReadStrategies;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies\FilterWithoutBatchWithoutCountOrder;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;

class FilterWithoutBatchWithoutCountOrderTest extends TestCase
{
    private const DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_BATCH_PAGE_SIZE = 65;
    private BulkItemsReaderInterface $bulkItemsReader;
    private ServiceBuilder $serviceBuilder;
    private Stopwatch $stopwatch;
    private int $contactId;
    /**
     * @var int[]
     */
    private array $dealId;
    /**
     * @var array<string,mixed>
     */
    private array $filter;


    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @covers  \Bitrix24\SDK\Core\Batch::getTraversableList
     * @testdox Get traversable list filter without batch without count ordered result
     */
    public function testGetTraversableListFilterWithoutBatchWithoutCountOrder(): void
    {
        $elementsCountByFilter = $this->serviceBuilder->getCRMScope()->deal()->countByFilter($this->filter);
        $this->assertEquals(self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_BATCH_PAGE_SIZE, $elementsCountByFilter);


        $select = [
            'ID',
            'TITLE',
            'OPPORTUNITY',
        ];

        $elementsCount = 0;
        $this->stopwatch->start('FilterWithoutBatchWithoutCountOrder');
        foreach (
            $this->bulkItemsReader->getTraversableList(
                'crm.deal.list',
                ['ID' => 'ASC'],
                $this->filter,
                $select
            ) as $cnt => $dealItem
        ) {
            $elementsCount++;
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

        print(sprintf(
                'FilterWithoutBatchWithoutCountOrder: %s ms',
                $this->stopwatch->getEvent('FilterWithoutBatchWithoutCountOrder')->getDuration()
            ) . PHP_EOL);

        $this->assertTrue(true);
    }

    public function setUp(): void
    {
        $this->stopwatch = new Stopwatch(true);
        $this->serviceBuilder = Fabric::getServiceBuilder();
        $this->bulkItemsReader = new FilterWithoutBatchWithoutCountOrder(
            Fabric::getCore(),
            Fabric::getLogger()
        );

        // prepare demo data
        // add contact
        $this->contactId = $this->serviceBuilder->getCRMScope()->contact()->add(
            [
                'NAME'   => sprintf('first_%s', time()),
                'SECOND' => sprintf('second_%s', time()),
            ]
        )->getId();

        $this->filter = [
            'CONTACT_ID' => $this->contactId,
        ];

        // add deals to bitrix24
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_BATCH_PAGE_SIZE; $i++) {
            $rawDeals[] = [
                'TITLE'                 => sprintf('deal-%s', $i),
                'IS_MANUAL_OPPORTUNITY' => 'Y',
                'OPPORTUNITY'           => sprintf('%s.00', random_int(100, 40000)),
                'CURRENCY_ID'           => 'RUB',
                'CONTACT_ID'            => $this->contactId,
            ];
        }
        foreach ($this->serviceBuilder->getCRMScope()->deal()->batch->add($rawDeals) as $addDealResult) {
            $this->dealId[] = $addDealResult->getId();
        }
    }

    public function tearDown(): void
    {
        // clear demo data
        $this->serviceBuilder->getCRMScope()->contact()->delete($this->contactId);
        $cnt = 0;
        foreach ($this->serviceBuilder->getCRMScope()->deal()->batch->delete($this->dealId) as $cnt => $result) {
            $cnt++;
        }
    }
}