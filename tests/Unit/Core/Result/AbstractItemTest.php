<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Core\Result;

use Bitrix24\SDK\Core\Exceptions\ImmutableResultViolationException;
use Bitrix24\SDK\Core\Result\AbstractItem;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractItemTest
 *
 * @package Bitrix24\SDK\Tests\Unit\Core\Result
 */
class AbstractItemTest extends TestCase
{
    /**
     * @covers \Bitrix24\SDK\Core\Result\AbstractItem::__set
     */
    public function testSetPropertyItem(): void
    {
        $this->expectException(ImmutableResultViolationException::class);
        $testItem = new class (['ID' => 1]) extends AbstractItem {
        };
        $testItem->ID = 2;
    }

    /**
     * @covers \Bitrix24\SDK\Core\Result\AbstractItem::__unset
     */
    public function testUnsetPropertyItem(): void
    {
        $this->expectException(ImmutableResultViolationException::class);
        $testItem = new class (['ID' => 1]) extends AbstractItem {
        };
        unset($testItem->ID);
    }
}