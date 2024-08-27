<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Catalog\Product\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Catalog\Catalog\Service\Catalog;
use Bitrix24\SDK\Services\Catalog\Common\ProductType;
use Bitrix24\SDK\Services\Catalog\Product\Service\Product;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(Product::class)]
class ProductTest extends TestCase
{
    protected Product $productService;

    protected Catalog $catalogService;

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test Product::fieldsByFilter')]
    public function testFieldsByFilter(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $this->assertIsArray($this->productService->fieldsByFilter(
            $iblockId,
            ProductType::simple
        )->getFieldsDescription());
    }

    /**
     * @throws BaseException If there is a base exception thrown during the product addition process.
     * @throws TransportException If there is a transport exception thrown during the product addition process.
     */
    #[TestDox('test Product::add')]
    public function testAdd(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
            ''
        ];
        $productResult = $this->productService->add($fields);
        $this->assertEquals($fields['name'], $productResult->product()->name);
        $this->productService->delete($productResult->product()->id);
    }

    /**
     * @throws BaseException If there is a base exception thrown during the product retrieval process.
     * @throws TransportException If there is a transport exception thrown during the product retrieval process.
     */
    #[TestDox('test Product::get')]
    public function testGet(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
        ];
        $productResult = $this->productService->add($fields);
        $productGet = $this->productService->get($productResult->product()->id);
        $this->assertEquals($productResult->product()->id, $productGet->product()->id);
        $this->productService->delete($productGet->product()->id);
    }

    /**
     * Deletes a product from the system and asserts that the product was deleted successfully.
     *
     * @throws BaseException If there is a base exception thrown during the product deletion process.
     * @throws TransportException If there is a transport exception thrown during the product deletion process.
     */
    #[TestDox('test Product::delete')]
    public function testDelete(): void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
        ];
        $productResult = $this->productService->add($fields);
        $productGet = $this->productService->get($productResult->product()->id);
        $this->assertEquals($productResult->product()->id, $productGet->product()->id);
        $this->productService->delete($productGet->product()->id);

        $productsResult = $this->productService->list(
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
        $this->assertCount(0, $productsResult->getProducts());
    }

    /**
     * Retrieves a list of products that match the specified filter criteria and asserts that the expected number of products is returned.
     *
     * @throws BaseException If there is a base exception thrown during the process of listing products.
     * @throws TransportException If there is a transport exception thrown during the process of listing products.
     */
    #[TestDox('test Product::list')]
    public function testList():void
    {
        $iblockId = $this->catalogService->list([], [], [], 1)->getCatalogs()[0]->iblockId;
        $fields = [
            'iblockId' => $iblockId,
            'name' => sprintf('test product name %s', time()),
        ];
        $productResult = $this->productService->add($fields);
        $productGet = $this->productService->get($productResult->product()->id);
        $this->assertEquals($productResult->product()->id, $productGet->product()->id);
        $productsResult = $this->productService->list(
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
        $this->assertCount(1, $productsResult->getProducts());
    }

    protected function setUp(): void
    {
        $this->productService = Fabric::getServiceBuilder()->getCatalogScope()->product();
        $this->catalogService = Fabric::getServiceBuilder()->getCatalogScope()->catalog();
    }
}