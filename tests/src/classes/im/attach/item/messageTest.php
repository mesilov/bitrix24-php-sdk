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

use \Bitrix24\Im\Attach\Item\Message;
use \Psr\Log\NullLogger;

/**
 * Class MessageTest
 * @package Bitrix24
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Bitrix24\Im\Attach\Item\Message::getAttachTypeCode
	 */
	public function testUserListWithNullArgument()
	{
		$obItem = new Message('Test message');
		$this->assertSame($obItem->getAttachTypeCode(), 'MESSAGE');
	}
}