<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\Main;

use Bitrix24\SDK\Services\Main\MainServiceBuilder;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Unit\Stubs\NullBatch;
use Bitrix24\SDK\Tests\Unit\Stubs\NullBulkItemsReader;
use Bitrix24\SDK\Tests\Unit\Stubs\NullCore;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class CRMServiceBuilderTest
 *
 * @package Bitrix24\SDK\Tests\Unit\Services\CRM
 */
class MainServiceBuilderTest extends TestCase
{
    private MainServiceBuilder $serviceBuilder;

    /**
     * @covers \Bitrix24\SDK\Services\Main\MainServiceBuilder::main
     */
    public function testGetMainService(): void
    {
        $this->serviceBuilder->main();
        $this::assertTrue(true);
    }

    public function setUp(): void
    {
        $this->serviceBuilder = (new ServiceBuilder(
            new NullCore(),
            new NullBatch(),
            new NullBulkItemsReader(),
            new NullLogger()
        ))->getMainScope();
    }
}