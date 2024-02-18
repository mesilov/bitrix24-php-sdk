<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Catalog\Product\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Catalog\Catalog\Service\Catalog;
use Bitrix24\SDK\Services\Catalog\Common\ProductType;
use Bitrix24\SDK\Services\Catalog\Product\Service\Product;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    protected Product $productService;
    protected Catalog $catalogService;

    /**
     * Tests the fieldsByFilter method.
     *
     * @return void
     *
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\Catalog\Product\Service\Product::fieldsByFilter
     * @testdox test Product::fieldsByFilter
     */
    public function testFieldsByFilter(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $this->assertIsArray($this->productService->fieldsByFilter(
            $iblockId,
            ProductType::simple
        )->getFieldsDescription());
    }

    /**
     * Adds a new product to the system and asserts that the product was added successfully.
     *
     * @return void
     * @throws BaseException If there is a base exception thrown during the product addition process.
     * @throws TransportException If there is a transport exception thrown during the product addition process.
     * @covers Product::add()
     */
    public function testAdd(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
            ''
        ];
        $result = $this->productService->add($fields);
        $this->assertEquals($fields['name'], $result->product()->name);
        $this->productService->delete($result->product()->id);
    }

    /**
     * Retrieves a product from the system and asserts that the correct product was retrieved.
     *
     * @return void
     * @throws BaseException If there is a base exception thrown during the product retrieval process.
     * @throws TransportException If there is a transport exception thrown during the product retrieval process.
     * @covers Product::get()
     */
    public function testGet(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
        ];
        $result = $this->productService->add($fields);
        $productGet = $this->productService->get($result->product()->id);
        $this->assertEquals($result->product()->id, $productGet->product()->id);
        $this->productService->delete($productGet->product()->id);
    }

    /**
     * Deletes a product from the system and asserts that the product was deleted successfully.
     *
     * @return void
     * @throws BaseException If there is a base exception thrown during the product deletion process.
     * @throws TransportException If there is a transport exception thrown during the product deletion process.
     * @covers Product::delete()
     * @testdox test Product::delete
     */
    public function testDelete(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
        ];
        $result = $this->productService->add($fields);
        $productGet = $this->productService->get($result->product()->id);
        $this->assertEquals($result->product()->id, $productGet->product()->id);
        $this->productService->delete($productGet->product()->id);

        $filteredProducts = $this->productService->list(
            [
                'id',
                'iblockId'
            ],
            [
                'id' => $productGet->product()->id,
                'iblockId' => $iblockId
            ],
            [
                'id' => 'asc'
            ],
            1
        );
        $this->assertCount(0, $filteredProducts->getProducts());
    }

    /**
     * Retrieves a list of products that match the specified filter criteria and asserts that the expected number of products is returned.
     *
     * @return void
     * @throws BaseException If there is a base exception thrown during the process of listing products.
     * @throws TransportException If there is a transport exception thrown during the process of listing products.
     * @covers Product::list()
     */
    public function testList():void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
        ];
        $result = $this->productService->add($fields);
        $productGet = $this->productService->get($result->product()->id);
        $this->assertEquals($result->product()->id, $productGet->product()->id);
        $filteredProducts = $this->productService->list(
            [
                'id',
                'iblockId'
            ],
            [
                'id' => $productGet->product()->id,
                'iblockId' => $iblockId
            ],
            [
                'id' => 'asc'
            ],
            1
        );
        $this->assertCount(1, $filteredProducts->getProducts());
    }

    public function setUp(): void
    {
        $this->productService = Fabric::getServiceBuilder()->getCatalogScope()->product();
        $this->catalogService = Fabric::getServiceBuilder()->getCatalogScope()->catalog();
    }
}