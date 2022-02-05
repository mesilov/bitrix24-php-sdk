<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Core\BulkItemsReader\ReadStrategies;

use Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies\FilterWithBatchWithoutCountOrder;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;

class FilterWithBatchWithoutCountOrderTest extends TestCase
{
    private BulkItemsReaderInterface $bulkItemsReader;
    private ServiceBuilder $serviceBuilder;
    private Stopwatch $stopwatch;
    private int $contactId;
    /**
     * @var int[]
     */
    private array $dealId;
    private const DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_BATCH_PAGE_SIZE = 65;
    /**
     * @var array<string,mixed>
     */
    private array $filter;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @covers  FilterWithBatchWithoutCountOrder::getTraversableList
     * @testdox Get traversable list batch without count elements on every api call with elements count more than batch page size - 2500 elements
     */
    public function testGetTraversableListBatchWithoutCountElementsOnEveryApiCallWithMoreThanBatchPageSizeFilterResult(): void
    {
        $elementsCountByFilter = $this->serviceBuilder->getCRMScope()->deal()->countByFilter($this->filter);
        $this->assertEquals(self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_BATCH_PAGE_SIZE, $elementsCountByFilter);

        $select = [
            'ID',
            'TITLE',
            'OPPORTUNITY',
        ];

        $elementsCount = 0;
        $this->stopwatch->start('FilterWithBatchWithoutCountOrder.getTraversableList');
        foreach ($this->bulkItemsReader->getTraversableList('crm.deal.list', [], $this->filter, $select) as $cnt => $dealItem) {
            $elementsCount++;
        }
        $this->stopwatch->stop('FilterWithBatchWithoutCountOrder.getTraversableList');
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
                'duration for FilterWithBatchWithoutCountOrder.getTraversableList: %s ms',
                $this->stopwatch->getEvent('FilterWithBatchWithoutCountOrder.getTraversableList')->getDuration()
            ) . PHP_EOL);
    }

    public function setUp(): void
    {
        $this->stopwatch = new Stopwatch(true);
        $this->serviceBuilder = Fabric::getServiceBuilder();
        $this->bulkItemsReader = new FilterWithBatchWithoutCountOrder(
            Fabric::getBatchService(),
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