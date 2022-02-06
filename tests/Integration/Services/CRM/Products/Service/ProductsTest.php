<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Products\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Product\Service\Product;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase
{
    protected Product $productService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Product::add
     */
    public function testAdd(): void
    {
        self::assertGreaterThan(1, $this->productService->add(['NAME' => 'test product'])->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Product::delete
     */
    public function testDelete(): void
    {
        self::assertTrue($this->productService->delete($this->productService->add(['NAME' => 'test product'])->getId())->isSuccess());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Product::get
     */
    public function testGet(): void
    {
        $product = [
            'NAME' => 'test product',
        ];
        $addProductResult = $this->productService->get($this->productService->add($product)->getId());
        self::assertGreaterThan(
            1,
            $addProductResult->product()->ID
        );
        self::assertEquals(
            $product['NAME'],
            $addProductResult->product()->NAME
        );
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Product::fields
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        self::assertIsArray($this->productService->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Product::list
     */
    public function testList(): void
    {
        $this->productService->add(['NAME' => 'test']);
        self::assertGreaterThanOrEqual(1, $this->productService->list([], [], ['ID', 'NAME'])->getProducts());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Product::update
     */
    public function testUpdate(): void
    {
        $product = $this->productService->add(['NAME' => 'test']);
        $newName = 'test2';

        self::assertTrue($this->productService->update($product->getId(), ['NAME' => $newName])->isSuccess());
        self::assertEquals($newName, $this->productService->get($product->getId())->product()->NAME);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Batch::list()
     * @throws BaseException
     * @throws TransportException
     */
    public function testBatchList(): void
    {
        $this->productService->add(['NAME' => 'test product']);
        $cnt = 0;

        foreach ($this->productService->batch->list([], ['>ID' => '1'], ['ID', 'NAME'], 1) as $item) {
            $cnt++;
        }
        self::assertGreaterThanOrEqual(1, $cnt);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Batch::add()
     */
    public function testBatchAdd(): void
    {
        $products = [];
        for ($i = 1; $i < 60; $i++) {
            $products[] = ['NAME' => 'NAME-' . $i];
        }
        $cnt = 0;
        foreach ($this->productService->batch->add($products) as $item) {
            $cnt++;
        }

        self::assertEquals(count($products), $cnt);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Product\Service\Product::countByFilter
     */
    public function testCountByFilter(): void
    {
        $productsCountBefore = $this->productService->countByFilter();
        $newProductsCount = 60;
        $products = [];
        for ($i = 1; $i <= $newProductsCount; $i++) {
            $products[] = ['NAME' => 'NAME-' . $i];
        }
        $cnt = 0;
        foreach ($this->productService->batch->add($products) as $item) {
            $cnt++;
        }

        self::assertEquals(count($products), $cnt);

        $productsCountAfter = $this->productService->countByFilter();
        $this->assertEquals($productsCountBefore + $newProductsCount, $productsCountAfter);
    }

    public function setUp(): void
    {
        $this->productService = Fabric::getServiceBuilder()->getCRMScope()->product();
    }
}