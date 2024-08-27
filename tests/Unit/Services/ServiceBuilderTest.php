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
#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Services\ServiceBuilder::class)]
class ServiceBuilderTest extends TestCase
{
    private ServiceBuilder $serviceBuilder;

    public function testGetMainScopeBuilder(): void
    {
        $this->serviceBuilder->getMainScope();
        $this::assertTrue(true);
    }

    public function testGetIMScopeBuilder(): void
    {
        $this->serviceBuilder->getIMScope();
        $this::assertTrue(true);
    }

    public function testGetCrmScopeBuilder(): void
    {
        $this->serviceBuilder->getCRMScope();
        $this::assertTrue(true);
    }

    protected function setUp(): void
    {
        $this->serviceBuilder = new ServiceBuilder(
            new NullCore(),
            new NullBatch(),
            new NullBulkItemsReader(),
            new NullLogger()
        );
    }
}