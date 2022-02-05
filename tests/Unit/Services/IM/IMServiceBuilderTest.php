<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\IM;

use Bitrix24\SDK\Services\IM\IMServiceBuilder;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Unit\Stubs\NullBatch;
use Bitrix24\SDK\Tests\Unit\Stubs\NullBulkItemsReader;
use Bitrix24\SDK\Tests\Unit\Stubs\NullCore;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class IMServiceBuilderTest
 *
 * @package Bitrix24\SDK\Tests\Unit\Services\IM
 */
class IMServiceBuilderTest extends TestCase
{
    private IMServiceBuilder $serviceBuilder;

    /**
     * @covers \Bitrix24\SDK\Services\IM\IMServiceBuilder::IM
     */
    public function testGetIMService(): void
    {
        $this->serviceBuilder->IM();
        $this::assertTrue(true);
    }

    public function setUp(): void
    {
        $this->serviceBuilder = (
        new ServiceBuilder(
            new NullCore(),
            new NullBatch(),
            new NullBulkItemsReader(),
            new NullLogger()
        ))->getIMScope();
    }
}