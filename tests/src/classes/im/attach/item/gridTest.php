<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24;

use \Bitrix24\Im\Attach\Item\Grid;
use \Psr\Log\NullLogger;

/**
 * Class GridTest
 * @package Bitrix24
 */
class GridTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Bitrix24\Im\Attach\Item\Grid::getAttachTypeCode
	 */
	public function testGridTypeCode()
	{
		$obItem = new Grid();
		$this->assertSame($obItem->getAttachTypeCode(), 'GRID');
	}
}