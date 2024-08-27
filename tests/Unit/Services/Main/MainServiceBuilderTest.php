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
#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Services\Main\MainServiceBuilder::class)]
class MainServiceBuilderTest extends TestCase
{
    private MainServiceBuilder $serviceBuilder;

    public function testGetMainService(): void
    {
        $this->serviceBuilder->main();
        $this::assertTrue(true);
    }

    protected function setUp(): void
    {
        $this->serviceBuilder = (new ServiceBuilder(
            new NullCore(),
            new NullBatch(),
            new NullBulkItemsReader(),
            new NullLogger()
        ))->getMainScope();
    }
}