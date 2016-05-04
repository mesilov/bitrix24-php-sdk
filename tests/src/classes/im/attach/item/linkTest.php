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

use \Bitrix24\Im\Attach\Item\Link;
use \Psr\Log\NullLogger;

/**
 * Class LinkTest
 * @package Bitrix24
 */
class LinkTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Bitrix24\Im\Attach\Item\Link::getAttachTypeCode
	 */
	public function testLinkTypeCode()
	{
		$obItem = new Link(null, null, null, null);
		$this->assertSame($obItem->getAttachTypeCode(), 'LINK');
	}
}