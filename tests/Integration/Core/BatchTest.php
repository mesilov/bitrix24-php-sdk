<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Core;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;

class BatchTest extends TestCase
{
    private Batch $batch;
    private ServiceBuilder $serviceBuilder;
    private Stopwatch $stopwatch;
    private const DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE = 35;
    private const DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_PAGE_SIZE = 65;
    private const LIMIT_ELEMENTS_IN_RESULT = 10;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @covers  \Bitrix24\SDK\Core\Batch::getTraversableList
     * @testdox Get traversable list items in batch mode with more than max batch page count elements
     */
    public function testGetTraversableListWithMoreThanMaxBatchPageCountWithoutLimit(): void
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
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_PAGE_SIZE; $i++) {
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
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_PAGE_SIZE, $dealIdList);


        // count added deals by default deal service
        $filter = [
            'CONTACT_ID' => $contactId,
        ];

        $elementsCountByFilter = $this->serviceBuilder->getCRMScope()->deal()->countByFilter($filter);
        $this->assertEquals(self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_PAGE_SIZE, $elementsCountByFilter);

        $select = [
            '*',
        ];

        $dealIdListFromBatch = [];
        $batchElementsCount = 0;
        $this->stopwatch->start('getTraversableList');
        foreach ($this->batch->getTraversableList('crm.deal.list', [], $filter, $select) as $cnt => $dealItem) {
            $batchElementsCount++;
            $dealIdListFromBatch[] = $dealItem['ID'];
        }
        $this->stopwatch->stop('getTraversableList');
        $this->assertEquals(
            self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_PAGE_SIZE,
            $batchElementsCount,
            sprintf(
                'elements count by filter %s not equals elements count from batch getTraversableList  %s',
                $elementsCountByFilter,
                $batchElementsCount
            )
        );
        $this->assertEquals($dealIdList, $dealIdListFromBatch, sprintf('added deal id array doesnt not equals array in batch result list'));

        print(sprintf(
            'getTraversableList timing - %s ms | %s sec' . PHP_EOL,
            $this->stopwatch->getEvent('getTraversableList')->getDuration(),
            $this->stopwatch->getEvent('getTraversableList')->getDuration() / 1000
        ));

        //try to delete deals
        $deletedItemsCount = 0;
        foreach ($this->batch->deleteEntityItems('crm.deal.delete', $dealIdList) as $cnt => $deletedResult) {
            $deletedItemsCount++;
        }
        $this->assertEquals(
            self::DEMO_DATA_ARRAY_SIZE_MORE_THAN_ONE_PAGE_SIZE,
            $deletedItemsCount,
            sprintf(
                'elements count by filter %s not equals deleted elements count from batch deleteEntityItems  %s',
                $elementsCountByFilter,
                $deletedItemsCount
            )
        );
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @covers  \Bitrix24\SDK\Core\Batch::getTraversableList
     * @testdox Get traversable list items in batch mode with less than one page with limit elements
     */
    public function testGetTraversableListWithLessThanPageSizeWithLimit(): void
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
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE; $i++) {
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
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE, $dealIdList);


        // count added deals by default deal service
        $filter = [
            'CONTACT_ID' => $contactId,
        ];

        $elementsCountByFilter = $this->serviceBuilder->getCRMScope()->deal()->countByFilter($filter);
        $this->assertEquals(self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE, $elementsCountByFilter);

        $select = [
            'ID',
            'TITLE',
            'OPPORTUNITY',
        ];

        $limitElements = self::LIMIT_ELEMENTS_IN_RESULT;
        $batchElementsCount = 0;
        $this->stopwatch->start('getTraversableList');
        foreach ($this->batch->getTraversableList('crm.deal.list', [], $filter, $select, $limitElements) as $cnt => $dealItem) {
            $batchElementsCount++;
            print(sprintf(
                    '%s-%s| %s | %s - %s',
                    $cnt,
                    $limitElements,
                    $dealItem['ID'],
                    $dealItem['TITLE'],
                    $dealItem['OPPORTUNITY'],
                ) . PHP_EOL);
        }
        $this->stopwatch->stop('getTraversableList');
        $this->assertEquals(
            $limitElements,
            $batchElementsCount,
            sprintf(
                'elements count by filter %s not equals elements count from batch getTraversableList  %s',
                $limitElements,
                $batchElementsCount
            )
        );
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @covers  \Bitrix24\SDK\Core\Batch::getTraversableList
     * @testdox Get traversable list items in batch mode with count more than one page without limit
     */
    public function testGetTraversableListWithLessThanPageSizeWithoutLimit(): void
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
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE; $i++) {
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
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE, $dealIdList);


        // count added deals by default deal service
        $filter = [
            'CONTACT_ID' => $contactId,
        ];

        $elementsCountByFilter = $this->serviceBuilder->getCRMScope()->deal()->countByFilter($filter);
        $this->assertEquals(self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE, $elementsCountByFilter);

        $select = [
            'ID',
            'TITLE',
            'OPPORTUNITY',
        ];

        $batchElementsCount = 0;
        $this->stopwatch->start('getTraversableList');
        foreach ($this->batch->getTraversableList('crm.deal.list', [], $filter, $select) as $cnt => $dealItem) {
            $batchElementsCount++;
            print(sprintf(
                    '%s-%s| %s | %s - %s',
                    $cnt,
                    $elementsCountByFilter,
                    $dealItem['ID'],
                    $dealItem['TITLE'],
                    $dealItem['OPPORTUNITY'],
                ) . PHP_EOL);
        }
        $this->stopwatch->stop('getTraversableList');
        $this->assertEquals(
            $elementsCountByFilter,
            $batchElementsCount,
            sprintf(
                'elements count by filter %s not equals elements count from batch getTraversableList  %s',
                $elementsCountByFilter,
                $batchElementsCount
            )
        );
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @covers  \Bitrix24\SDK\Core\Batch::addEntityItems
     * @testdox Add items in batch mode
     */
    public function testBatchAddEntityItems(): void
    {
        // prepare demo data
        $contactId = $this->serviceBuilder->getCRMScope()->contact()->add(
            [
                'NAME'   => sprintf('first_%s', time()),
                'SECOND' => sprintf('second_%s', time()),
            ]
        )->getId();
        $rawDeals = [];
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE; $i++) {
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
        foreach ($this->batch->addEntityItems('crm.deal.add', $rawDeals) as $cnt => $addDealResult) {
            $dealIdList[] = $addDealResult->getResult()->getResultData()[0];
        }
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE, $dealIdList);
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Exception
     * @covers  \Bitrix24\SDK\Core\Batch::addEntityItems
     * @covers  \Bitrix24\SDK\Core\Batch::deleteEntityItems
     * @testdox Delete items in batch mode
     */
    public function testBatchDeleteEntityItems(): void
    {
        // prepare demo data
        $contactId = $this->serviceBuilder->getCRMScope()->contact()->add(
            [
                'NAME'   => sprintf('first_%s', time()),
                'SECOND' => sprintf('second_%s', time()),
            ]
        )->getId();
        $rawDeals = [];
        for ($i = 0; $i < self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE; $i++) {
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
        foreach ($this->batch->addEntityItems('crm.deal.add', $rawDeals) as $cnt => $addDealResult) {
            $dealIdList[] = $addDealResult->getResult()->getResultData()[0];
        }
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE, $dealIdList);

        // delete deals from bitrix24
        $dealsDeleteResult = [];
        foreach ($this->batch->deleteEntityItems('crm.deal.delete', $dealIdList) as $cnt => $deleteDealResult) {
            $dealsDeleteResult[] = $deleteDealResult->getResult()->getResultData()[0];
        }
        $this->assertCount(self::DEMO_DATA_ARRAY_SIZE_LESS_THAN_PAGE, $dealsDeleteResult);
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @testdox Delete items in batch mode with wrong type of entity id
     */
    public function testBatchDeleteEntityItemsWithWrongTypeOfEntityId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        foreach ($this->batch->deleteEntityItems('crm.deal.delete', [1, 2, '3', 4, 5]) as $cnt => $deleteDealResult) {
            $dealsDeleteResult[] = $deleteDealResult->getResult()->getResultData()[0];
        }
    }

    public function setUp(): void
    {
        $this->stopwatch = new Stopwatch(true);
        $this->batch = Fabric::getBatchService();
        $this->serviceBuilder = Fabric::getServiceBuilder();
    }

    public function tearDown(): void
    {
    }
}