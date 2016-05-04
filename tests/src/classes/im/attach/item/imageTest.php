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

use \Bitrix24\Im\Attach\Item\Image;
use \Psr\Log\NullLogger;

/**
 * Class ImageTest
 * @package Bitrix24
 */
class ImageTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Bitrix24\Im\Attach\Item\Image::getAttachTypeCode
	 */
	public function testImageTypeCode()
	{
		$obItem = new Image(null, null);
		$this->assertSame($obItem->getAttachTypeCode(), 'IMAGE');
	}
}