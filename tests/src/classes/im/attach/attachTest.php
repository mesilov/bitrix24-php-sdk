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

use \Bitrix24\Im\Attach\Attach;
use \Psr\Log\NullLogger;

/**
 * Class AttachTest
 * @package Bitrix24
 */
class AttachTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Bitrix24\Im\Attach\Attach::__construct
	 */
	public function testAttachConstructWithNullArguments()
	{
		$obItem = new Attach(null, null);
	}

	/**
	 * @covers \Bitrix24\Im\Attach\Attach::setStatusNormal
	 */
	public function testAttachSetStatusNormal()
	{
		$obItem = new Attach(null, null);
		$obItem->setStatusNormal();
	}

	/**
	 * @covers \Bitrix24\Im\Attach\Attach::setStatusAttention
	 */
	public function testAttachSetStatusAttention()
	{
		$obItem = new Attach(null, null);
		$obItem->setStatusAttention();
	}

	/**
	 * @covers \Bitrix24\Im\Attach\Attach::setStatusProblem
	 */
	public function testAttachSetStatusProblem()
	{
		$obItem = new Attach(null, null);
		$obItem->setStatusProblem();
	}

	/**
	 * @covers \Bitrix24\Im\Attach\Attach::getData
	 */
	public function testAttachGetData()
	{
		$obItem = new Attach(null, null);
		$obItem->getData();
	}

	/**
	 * @covers \Bitrix24\Im\Attach\Attach::getAttachItems
	 */
	public function testAttachGetAttachItems()
	{
		$obItem = new Attach(null, null);
		$obItem->getAttachItems();
	}
}