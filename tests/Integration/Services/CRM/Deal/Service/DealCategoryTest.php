<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class DealCategoryTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Deals\Service
 */
class DealCategoryTest extends TestCase
{
    protected DealCategory $dealCategory;

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::add
     *
     * @throws BaseException
     * @throws TransportException
     */
    public function testAdd(): void
    {
        $countBefore = $this->dealCategory->list([], [], [], 0)->getCoreResponse()->getResponseData()->getPagination()->getTotal();
        $this::assertGreaterThanOrEqual(
            1,
            $this->dealCategory->add(
                [
                    'NAME' => 'test',
                    'SORT' => 20,
                ]
            )->getId()
        );
        $countAfter = $this->dealCategory->list([], [], [], 0)->getCoreResponse()->getResponseData()->getPagination()->getTotal();

        $this::assertEquals($countBefore + 1, $countAfter);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::delete
     * @throws BaseException
     * @throws TransportException
     */
    public function testDelete(): void
    {
        $this::assertTrue(
            $this->dealCategory->delete(
                $this->dealCategory->add(
                    [
                        'NAME' => 'test_name',
                    ]
                )->getId()
            )->isSuccess()
        );
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::fields
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        $this::assertIsArray($this->dealCategory->fields()->getFieldsDescription());
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::getDefaultCategorySettings
     * @throws BaseException
     * @throws TransportException
     */
    public function testDealCategoryDefaultGet(): void
    {
        $this::assertGreaterThanOrEqual(0, $this->dealCategory->getDefaultCategorySettings()->getDealCategoryFields()->ID);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::setDefaultCategorySettings
     * @throws BaseException
     * @throws TransportException
     */
    public function testDealCategoryDefaultSet(): void
    {
        $oldName = $this->dealCategory->getDefaultCategorySettings()->getDealCategoryFields()->NAME;
        $newName = (string)time();
        $this::assertTrue($this->dealCategory->setDefaultCategorySettings(['NAME' => $newName])->isSuccess());
        $this::assertNotSame($oldName, $this->dealCategory->getDefaultCategorySettings()->getDealCategoryFields()->NAME);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::get
     * @throws BaseException
     * @throws TransportException
     */
    public function testDealCategoryGet(): void
    {
        $newCategory = [
            'NAME' => 'test new deal category',
            'SORT' => 300,
        ];

        $newCategoryId = $this->dealCategory->add($newCategory)->getId();
        $category = $this->dealCategory->get($newCategoryId);

        $this::assertEquals($newCategory['NAME'], $category->getDealCategoryFields()->NAME);
        $this::assertEquals($newCategory['SORT'], $category->getDealCategoryFields()->SORT);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::list
     *
     * @throws BaseException
     * @throws TransportException
     */
    public function testList(): void
    {
        $res = $this->dealCategory->list([], [], [], 0);
        $this::assertGreaterThanOrEqual(1, count($res->getDealCategories()));
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::getStatus
     * @throws BaseException
     * @throws TransportException
     */
    public function testDealCategoryStatus(): void
    {
        $newCategory = [
            'NAME' => 'test new deal category',
            'SORT' => 300,
        ];
        $newCategoryId = $this->dealCategory->add($newCategory)->getId();
        $status = $this->dealCategory->getStatus($newCategoryId);
        $this::assertGreaterThan(1, strlen($status->getDealCategoryTypeId()));
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealCategory::update
     * @throws BaseException
     * @throws TransportException
     */
    public function testUpdate(): void
    {
        $newCategory = [
            'NAME' => 'test new deal category',
            'SORT' => 300,
        ];
        $newCategoryId = $this->dealCategory->add($newCategory)->getId();
        $this::assertTrue($this->dealCategory->update($newCategoryId, ['NAME' => 'updated'])->isSuccess());
        $this::assertEquals('updated', $this->dealCategory->get($newCategoryId)->getDealCategoryFields()->NAME);
    }

    public function setUp(): void
    {
        $this->dealCategory = Fabric::getServiceBuilder()->getCRMScope()->dealCategory();
    }
}