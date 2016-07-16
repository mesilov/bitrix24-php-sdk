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

use \Psr\Log\NullLogger;

/**
 * Class Bitrix24Test
 * @package Bitrix24
 */
class Bitrix24Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers Bitrix24::__construct
	 */
	public function testConstructorWithFirstArgumentIsNotBoolean()
	{
		$this->setExpectedException('\Bitrix24\Exceptions\Bitrix24Exception');
		$obBitrix24 = new Bitrix24(array());
	}
	/**
	 * @covers Bitrix24::__construct
	 */
	public function testConstructorWithoutSecondArgument()
	{
		$obBitrix24 = new Bitrix24(false);
	}
	/**
	 * @covers Bitrix24::__construct
	 */
	public function testConstructorWithStubLogger()
	{
		$obBitrix24 = new Bitrix24(false, new NullLogger());
	}
	/**
	 * @covers Bitrix24::setMemberId
	 */
	public function testSetMemberIdWithValidArgument()
	{
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setMemberId('valid_member_id');
		$this->assertTrue($result);
	}
	/**
	 * @covers Bitrix24::setMemberId
	 */
	public function testSetMemberIdWithNullArgument()
	{
		$this->setExpectedException('\Bitrix24\Exceptions\Bitrix24Exception');
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setMemberId(null);
		$this->assertTrue($result);
	}
	/**
	 * @covers Bitrix24::setMemberId
	 */
	public function testSetMemberIdWithEmptyStringArgument()
	{
		$this->setExpectedException('\Bitrix24\Exceptions\Bitrix24Exception');
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setMemberId('');
		$this->assertTrue($result);
	}
	/**
	 * @covers Bitrix24::setRetriesToConnectCount
	 */
	public function testSetRetriesToConnectCountWithNull()
	{
		$this->setExpectedException('\Bitrix24\Exceptions\Bitrix24Exception');
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setRetriesToConnectCount(null);
	}
	/**
	 * @covers Bitrix24::setRetriesToConnectCount
	 */
	public function testSetRetriesToConnectCountWithEmptyArgs()
	{
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setRetriesToConnectCount();
		$this->assertTrue($result);
	}
	/**
	 * @covers Bitrix24::setRetriesToConnectCount
	 */
	public function testSetRetriesToConnectCountWithValidArgs()
	{
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setRetriesToConnectCount(1);
		$this->assertTrue($result);
	}
	/**
	 * @covers Bitrix24::setRetriesToConnectTimeout
	 */
	public function testSetRetriesToConnectTimeoutWithNull()
	{
		$this->setExpectedException('\Bitrix24\Exceptions\Bitrix24Exception');
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setRetriesToConnectTimeout(null);
	}
	/**
	 * @covers Bitrix24::setRetriesToConnectTimeout
	 */
	public function testSetRetriesToConnectTimeoutWithEmptyArgs()
	{
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setRetriesToConnectTimeout();
		$this->assertTrue($result);
	}
	/**
	 * @covers Bitrix24::setRetriesToConnectTimeout
	 */
	public function testSetRetriesToConnectTimeoutWithValidArgs()
	{
		$obBitrix24 = new Bitrix24(false, new NullLogger());
		$result = $obBitrix24->setRetriesToConnectTimeout(1000000);
		$this->assertTrue($result);
	}
}