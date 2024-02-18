<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Catalog\Catalog\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Catalog\Catalog\Service\Catalog;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class CatalogTest extends TestCase
{
    protected Catalog $service;

    /**
     * Test the Fields method.
     *
     * @return void
     * @throws BaseException if there is a base exception occurred
     * @throws TransportException if there is a transport exception occurred
     * @covers \Bitrix24\SDK\Services\Catalog\Catalog\Service\Catalog::fields
     * @testdox Test Catalog::fields method
     */
    public function testFields(): void
    {
        $this->assertIsArray($this->service->fields()->getFieldsDescription());
    }

    /**
     * Test the List method.
     *
     * @return void
     * @throws BaseException if there is a base exception occurred
     * @throws TransportException if there is a transport exception occurred
     * @covers \Bitrix24\SDK\Services\Catalog\Catalog\Service\Catalog::list
     */
    public function testList(): void
    {
        $this->assertGreaterThan(1, $this->service->list([], [], [], 1)->getCatalogs()[0]->id);
    }

    /**
     * Retrieves a catalog using the `get` method and asserts that the retrieved catalog's ID matches the original catalog's ID.
     *
     * @return void
     * @throws BaseException if there is a general exception.
     * @throws TransportException if there is an exception during transport.
     * @covers \Bitrix24\SDK\Services\Catalog\Catalog\Service\Catalog::get
     */
    public function testGet(): void
    {
        $catalog = $this->service->list([], [], [], 1)->getCatalogs()[0];
        $this->assertEquals($catalog->id, $this->service->get($catalog->id)->catalog()->id);
    }

    public function setUp(): void
    {
        $this->service = Fabric::getServiceBuilder()->getCatalogScope()->catalog();
    }
}