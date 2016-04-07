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

use \Bitrix24\Im\Chat;
use \Bitrix24\Contracts\iBitrix24;
use \Bitrix24\Stub\Bitrix24 as Bitrix24NullObject;

use \Psr\Log\NullLogger;

/**
 * Class ChatTest
 * @package Bitrix24
 */
class ChatTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var iBitrix24
	 */
	protected $bitrix24App;

	/**
	 * @var int
	 */
	protected $defaultChatId;

	/**
	 * @return void
	 */
	protected function setUp()
	{
		$this->bitrix24App = new Bitrix24NullObject();
		$this->defaultChatId = 1;
	}

	/**
	 * @covers \Bitrix24\Im\Chat::userList
	 */
	public function testUserListWithNullArgument()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userList(null);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::userList
	 */
	public function testUserListWithNumericArgument()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userList($this->defaultChatId);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::add
	 */
	public function testAddChatWithTitleAndDescription()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->add('chat title', 'chat description');
	}

	/**
	 * @covers \Bitrix24\Im\Chat::delete
	 */
	public function testDeleteWithNullArgument()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->delete(null);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::delete
	 */
	public function testDeleteWithNumericArgument()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->delete($this->defaultChatId);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::setOwner
	 */
	public function testSetOwnerWithNullChatId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->setOwner(null, $this->defaultChatId);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::setOwner
	 */
	public function testSetOwnerWithNullUserId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->setOwner($this->defaultChatId, null);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::setOwner
	 */
	public function testSetOwnerWithValidArguments()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->setOwner($this->defaultChatId, 1);
	}

	/**
	 * @covers  \Bitrix24\Im\Chat::updateColor
	 */
	public function testUpdateColorWithValidArguments()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateColor($this->defaultChatId, 'RED');
	}

	/**
	 * @covers \Bitrix24\Im\Chat::updateColor
	 */
	public function testUpdateColorWithNullChatId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateColor(null, 'RED');
	}

	/**
	 * @covers \Bitrix24\Im\Chat::updateColor
	 */
	public function testUpdateColorWithNullColor()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateColor($this->defaultChatId, null);
	}

	/**
	 * @covers  \Bitrix24\Im\Chat::updateTitle
	 */
	public function testUpdateTitleWithValidArguments()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateTitle($this->defaultChatId, 'test title');
	}

	/**
	 * @covers \Bitrix24\Im\Chat::updateTitle
	 */
	public function testUpdateTitleWithNullChatId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateTitle(null, 'test title');
	}

	/**
	 * @covers \Bitrix24\Im\Chat::updateTitle
	 */
	public function testUpdateTitleWithNullTitle()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateTitle($this->defaultChatId, null);
	}

	/**
	 * @covers  \Bitrix24\Im\Chat::updateAvatar
	 */
	public function testUpdateAvatarWithValidArguments()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateAvatar($this->defaultChatId, 'test avatar');
	}

	/**
	 * @covers \Bitrix24\Im\Chat::updateAvatar
	 */
	public function testUpdateAvatarWithNullChatId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateAvatar(null, 'test avatar');
	}

	/**
	 * @covers \Bitrix24\Im\Chat::updateAvatar
	 */
	public function testUpdateAvatarWithNullAvatar()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->updateAvatar($this->defaultChatId, null);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::sendTyping
	 */
	public function testSendTypingWithValidArguments()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->sendTyping($this->defaultChatId);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::sendTyping
	 */
	public function testSendTypingWithNullChatId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->sendTyping(null);
	}

	/**
	 * @covers  \Bitrix24\Im\Chat::userDelete
	 */
	public function testUserDeleteWithValidArguments()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userDelete($this->defaultChatId, 1);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::userDelete
	 */
	public function testUserDeleteWithNullChatId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userDelete(null, 1);
	}

	/**
	 * @covers \Bitrix24\Im\Chat::userDelete
	 */
	public function testUserDeleteWithNullUserId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userDelete($this->defaultChatId, null);
	}

	/**
	 * @covers  \Bitrix24\Im\Chat::userAdd
	 */
	public function testUserAddWithValidArguments()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userAdd($this->defaultChatId, array(2, 3, 4));
	}

	/**
	 * @covers \Bitrix24\Im\Chat::userAdd
	 */
	public function testUserAddWithNullChatId()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userAdd(null, array(2, 3, 4));
	}

	/**
	 * @covers \Bitrix24\Im\Chat::userAdd
	 */
	public function testUserAddWithEmptyArray()
	{
		$obChat = new Chat($this->bitrix24App);
		$obChat->userAdd($this->defaultChatId, array());
	}
}