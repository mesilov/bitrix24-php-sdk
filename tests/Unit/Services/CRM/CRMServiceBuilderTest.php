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
#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Services\CRM\CRMServiceBuilder::class)]
class CRMServiceBuilderTest extends TestCase
{
    private CRMServiceBuilder $serviceBuilder;

    public function testGetSettingsService(): void
    {
        $this->serviceBuilder->settings();
        $this::assertTrue(true);
    }

    public function testGetDealContactService(): void
    {
        $this->serviceBuilder->dealContact();
        $this::assertTrue(true);
    }

    public function testGetDealCategoryService(): void
    {
        $this->serviceBuilder->dealCategory();
        $this::assertTrue(true);
    }

    public function testDealService(): void
    {
        $this->serviceBuilder->deal();
        $this::assertTrue(true);
    }

    public function testContactService(): void
    {
        $this->serviceBuilder->contact();
        $this::assertTrue(true);
    }

    public function testDealProductRowsService(): void
    {
        $this->serviceBuilder->dealProductRows();
        $this::assertTrue(true);
    }

    public function testDealCategoryStageService(): void
    {
        $this->serviceBuilder->dealCategoryStage();
        $this::assertTrue(true);
    }

    protected function setUp(): void
    {
        $this->serviceBuilder = (new ServiceBuilder(
            new NullCore(),
            new NullBatch(),
            new NullBulkItemsReader(),
            new NullLogger()
        ))->getCRMScope();
    }
}