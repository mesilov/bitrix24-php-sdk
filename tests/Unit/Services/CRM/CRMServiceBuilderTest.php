<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\CRM;

use Bitrix24\SDK\Services\CRM\CRMServiceBuilder;
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
class CRMServiceBuilderTest extends TestCase
{
    private CRMServiceBuilder $serviceBuilder;

    /**
     * @covers \Bitrix24\SDK\Services\CRM\CRMServiceBuilder::settings
     */
    public function testGetSettingsService(): void
    {
        $this->serviceBuilder->settings();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\CRMServiceBuilder::dealContact
     */
    public function testGetDealContactService(): void
    {
        $this->serviceBuilder->dealContact();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\CRMServiceBuilder::dealCategory
     */
    public function testGetDealCategoryService(): void
    {
        $this->serviceBuilder->dealCategory();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\CRMServiceBuilder::dealCategory
     */
    public function testDealService(): void
    {
        $this->serviceBuilder->deal();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\CRMServiceBuilder::contact
     */
    public function testContactService(): void
    {
        $this->serviceBuilder->contact();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\CRMServiceBuilder::dealProductRows
     */
    public function testDealProductRowsService(): void
    {
        $this->serviceBuilder->dealProductRows();
        $this::assertTrue(true);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\CRMServiceBuilder::dealCategoryStage
     */
    public function testDealCategoryStageService(): void
    {
        $this->serviceBuilder->dealCategoryStage();
        $this::assertTrue(true);
    }

    public function setUp(): void
    {
        $this->serviceBuilder = (new ServiceBuilder(
            new NullCore(),
            new NullBatch(),
            new NullBulkItemsReader(),
            new NullLogger()
        ))->getCRMScope();
    }
}