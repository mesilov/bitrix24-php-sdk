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

use \Bitrix24\Im\Attach\Item\File;
use \Psr\Log\NullLogger;

/**
 * Class FileTest
 * @package Bitrix24
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Bitrix24\Im\Attach\Item\File::getAttachTypeCode
	 */
	public function testFileTypeCode()
	{
		$obItem = new File(null, null, null);
		$this->assertSame($obItem->getAttachTypeCode(), 'FILE');
	}
}