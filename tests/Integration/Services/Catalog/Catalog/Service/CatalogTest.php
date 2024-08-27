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

namespace Bitrix24\SDK\Tests\Integration\Services\Catalog\Catalog\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Catalog\Catalog\Service\Catalog;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Catalog::class)]
class CatalogTest extends TestCase
{
    protected Catalog $service;

    /**
     * @throws BaseException if there is a base exception occurred
     * @throws TransportException if there is a transport exception occurred
     */
    #[TestDox('Test Catalog::fields method')]
    public function testFields(): void
    {
        $this->assertIsArray($this->service->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException if there is a base exception occurred
     * @throws TransportException if there is a transport exception occurred
     */
    #[TestDox('Test Catalog::list method')]
    public function testList(): void
    {
        $this->assertGreaterThan(1, $this->service->list([], [], [], 1)->getCatalogs()[0]->id);
    }

    /**
     * @throws BaseException if there is a general exception.
     * @throws TransportException if there is an exception during transport.
     */
    #[TestDox('Test Catalog::get method')]
    public function testGet(): void
    {
        $catalog = $this->service->list([], [], [], 1)->getCatalogs()[0];
        $this->assertEquals($catalog->id, $this->service->get($catalog->id)->catalog()->id);
    }

    protected function setUp(): void
    {
        $this->service = Fabric::getServiceBuilder()->getCatalogScope()->catalog();
    }
}