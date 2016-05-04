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

use \Bitrix24\Im\Attach\Item\Delimiter;
use \Psr\Log\NullLogger;

/**
 * Class DelimiterTest
 * @package Bitrix24
 */
class DelimiterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Bitrix24\Im\Attach\Item\Delimiter::getAttachTypeCode
	 */
	public function testDelimiterTypeCode()
	{
		$obItem = new Delimiter();
		$this->assertSame($obItem->getAttachTypeCode(), 'DELIMITER');
	}
}