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

use Bitrix24\Stub\Logger as Bitrix24StubLogger;

/**
 * Class Bitrix24Test.
 */
class Bitrix24Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Bitrix24::__construct
     */
    public function testConstructorWithFirstArgumentIsNotBoolean()
    {
        $this->setExpectedException('\Bitrix24\Bitrix24Exception');
        $obBitrix24 = new Bitrix24([]);
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
        $obBitrix24 = new Bitrix24(false, new Bitrix24StubLogger());
    }

    /**
     * @covers Bitrix24::setMemberId
     */
    public function testSetMemberIdWithValidArgument()
    {
        $obBitrix24 = new Bitrix24(false, new Bitrix24StubLogger());
        $result = $obBitrix24->setMemberId('valid_member_id');
        $this->assertTrue($result);
    }

    /**
     * @covers Bitrix24::setMemberId
     */
    public function testSetMemberIdWithNullArgument()
    {
        $this->setExpectedException('\Bitrix24\Bitrix24Exception');
        $obBitrix24 = new Bitrix24(false, new Bitrix24StubLogger());
        $result = $obBitrix24->setMemberId(null);
        $this->assertTrue($result);
    }

    /**
     * @covers Bitrix24::setMemberId
     */
    public function testSetMemberIdWithEmptyStringArgument()
    {
        $this->setExpectedException('\Bitrix24\Bitrix24Exception');
        $obBitrix24 = new Bitrix24(false, new Bitrix24StubLogger());
        $result = $obBitrix24->setMemberId('');
        $this->assertTrue($result);
    }
}
