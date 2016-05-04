<?php
/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\Im;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Im\Fields as B24ImFields;
use Bitrix24\Im\Attach\Attach;

/**
 * Class Chat
 * @package Bitrix24\Im
 */
class Chat extends Bitrix24Entity
{
	/**
	 * create new chat
	 *
	 * @param string $title
	 * @param string $description
	 * @param string $color chat color in Bitrix24\Presets\Im\iChatColor for mobile
	 * @param string $message
	 * @param array $users
	 * @param string $avatarImgInBase64
	 * @param bool $isOpen
	 * 
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 *
	 * @return array
	 */
	public function add($title, $description='', $color ='', $message = '', array $users = array(), $avatarImgInBase64 = null, $isOpen = false)
	{
		$arParams = array(
			'title' =>  (string) $title,
			'description' =>  (string) $description,
			'color' => (string) $color,
			'message' => (string) $message,
			'users' => $users,
			'avatar' => $avatarImgInBase64,
		);
		
		if($isOpen)
		{
			$arParams['type'] = 'OPEN';
		}	
		return $this->client->call('im.chat.add', $arParams);
	}

	/**
	 * delete chat
	 *
	 * @param int $chatId
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function delete($chatId)
	{
		return $this->client->call('im.chat.delete', array(
			'chat_id' => (int) $chatId
		));
	}

	/**
	 * set chat owner
	 *
	 * @param $chatId
	 * @param $userId
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function setOwner($chatId, $userId)
	{
		return $this->client->call('im.chat.setOwner', array(
			'chat_id' => (int) $chatId,
			'user_id' => (int) $userId
		));
	}

	/**
	 * update color
	 *
	 * @param int $chatId
	 * @param string $newColor
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function updateColor($chatId, $newColor)
	{
		return $this->client->call('im.chat.updateColor', array(
			'chat_id' => (int) $chatId,
			'color' => (string) $newColor
		));
	}

	/**
	 * update title
	 *
	 * @param int $chatId
	 * @param string $newTitle
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function updateTitle($chatId, $newTitle)
	{
		return $this->client->call('im.chat.updateTitle', array(
			'chat_id' => (int) $chatId,
			'title' => (string) $newTitle
		));
	}

	/**
	 * update avatar
	 *
	 * @param int $chatId
	 * @param string $avatarImgInBase64
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function updateAvatar($chatId, $avatarImgInBase64)
	{
		return $this->client->call('im.chat.updateAvatar', array(
			'chat_id' => (int) $chatId,
			'avatar' => (string) $avatarImgInBase64
		));
	}


	/**
	 * send typing
	 *
	 * @param int $chatId
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function sendTyping($chatId)
	{
		return $this->client->call('im.chat.sendTyping', array(
			'chat_id' => (int) $chatId
		));
	}

	/**
	 * delete user from chat
	 *
	 * @param $chatId
	 * @param $userId
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function userDelete($chatId, $userId)
	{
		return $this->client->call('im.chat.user.delete', array(
			'chat_id' => (int) $chatId,
			'user_id' => (int) $userId
		));
	}

	/**
	 *
	 * @param $chatId
	 * @param array $arNewUsers
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException	 */
	public function userAdd($chatId, array $arNewUsers = array())
	{
		return $this->client->call('im.chat.user.add', array(
			'chat_id' => (int) $chatId,
			'user_id' => $arNewUsers
		));
	}

	/**
	 * get user list in chat
	 *
	 * @param $chatId
	 *
	 * @return array
	 *
	 * @throws Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24SecurityException
	 * @throws \Bitrix24\Bitrix24Exception
	 * @throws \Bitrix24\Bitrix24ApiException
	 * @throws \Bitrix24\Bitrix24TokenIsInvalid
	 * @throws \Bitrix24\Bitrix24TokenIsExpired
	 * @throws \Bitrix24\Bitrix24WrongClientException
	 * @throws \Bitrix24\Bitrix24MethodNotFoundException
	 * @throws \Bitrix24\Bitrix24SecurityException
	 */
	public function userList($chatId)
	{
		return $this->client->call('im.chat.user.list', array(
			'chat_id' => (int) $chatId
		));
	}	
}