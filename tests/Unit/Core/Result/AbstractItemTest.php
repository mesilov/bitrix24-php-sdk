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

namespace Bitrix24\SDK\Tests\Unit\Core\Result;

use Bitrix24\SDK\Core\Exceptions\ImmutableResultViolationException;
use Bitrix24\SDK\Core\Result\AbstractItem;
use PHPUnit\Framework\TestCase;

#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Core\Result\AbstractItem::class)]
class AbstractItemTest extends TestCase
{
    public function testSetPropertyItem(): void
    {
        $this->expectException(ImmutableResultViolationException::class);
        $testClassForAbstractItem = new TestClassForAbstractItem(['ID'=>1]);
        $testClassForAbstractItem->ID = 2;
    }

    public function testUnsetPropertyItem(): void
    {
        $this->expectException(ImmutableResultViolationException::class);
        $testClassForAbstractItem = new TestClassForAbstractItem(['ID'=>1]);
        unset($testClassForAbstractItem->ID);
    }
}

/**
 * @property int $ID
 */
class TestClassForAbstractItem extends AbstractItem
{
}