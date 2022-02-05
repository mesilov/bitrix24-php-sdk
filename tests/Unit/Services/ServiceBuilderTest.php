<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services;

use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Unit\Stubs\NullBatch;
use Bitrix24\SDK\Tests\Unit\Stubs\NullBulkItemsReader;
use Bitrix24\SDK\Tests\Unit\Stubs\NullCore;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class TestServiceBuilder
 *
 * @package Bitrix24\SDK\Tests\Unit\Services
 */
class ServiceBuilderTest extends TestCase
{
    private ServiceBuilder $serviceBuilder;

    /**
     * @covers \Bitrix24\SDK\Services\ServiceBuilder::getMainScope
     */
    public function testGetMainScopeBuilder(): void
    {
        $this->serviceBuilder->getMainScope();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\ServiceBuilder::getIMScope
     */
    public function testGetIMScopeBuilder(): void
    {
        $this->serviceBuilder->getIMScope();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\ServiceBuilder::getCRMScope
     */
    public function testGetCrmScopeBuilder(): void
    {
        $this->serviceBuilder->getCRMScope();
        $this::assertTrue(true);
    }

    public function setUp(): void
    {
        $this->serviceBuilder = new ServiceBuilder(
            new NullCore(),
            new NullBatch(),
            new NullBulkItemsReader(),
            new NullLogger()
        );
    }
}