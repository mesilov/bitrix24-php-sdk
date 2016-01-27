<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\Im\Attach\Item;
use Bitrix24\Im\Attach\iAttachItem;
/**
 * Class Grid
 * @package Bitrix24\Im\Attach\Item
 */
class Grid implements iAttachItem
{
	/**
	 * @var string
	 */
	const ATTACH_TYPE_CODE = 'GRID';
	/**
	 * @var array
	 */
	protected $arGridItems = array();

	/**
	 * Grid constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * @param $name
	 * @param $value
	 * @param null $color
	 * @param null $link
	 * @param null $chatId
	 * @param null $userId
	 */
	public function addBlockItem($name, $value, $color = null, $link = null, $chatId = null, $userId = null)
	{
		$this->arGridItems[] = array(
			'DISPLAY' => 'BLOCK',
			'NAME' => $name,
			'VALUE' => $value,
			'COLOR' => $color,
			'LINK' => $link,
			'CHAT_ID' => $chatId,
			'USER_ID' => $userId
		);
	}

	/**
	 * @param $name
	 * @param $value
	 * @param $width
	 * @param null $color
	 * @param null $link
	 * @param null $chatId
	 * @param null $userId
	 */
	public function addLineItem($name, $value, $width, $color = null, $link = null, $chatId = null, $userId = null)
	{
		$this->arGridItems[] = array(
			'DISPLAY' => 'LINE',
			'NAME' => $name,
			'VALUE' => $value,
			'WIDTH' => $width,
			'COLOR' => $color,
			'LINK' => $link,
			'CHAT_ID' => $chatId,
			'USER_ID' => $userId
		);
	}

	/**
	 * @param $name
	 * @param $value
	 * @param null $color
	 * @param null $link
	 * @param null $chatId
	 * @param null $userId
	 */
	public function addColumnItem($name, $value, $width, $color = null, $link = null, $chatId = null, $userId = null)
	{
		$this->arGridItems[] = array(
			'DISPLAY' => 'COLUMN',
			'NAME' => $name,
			'VALUE' => $value,
			'WIDTH' => $width,
			'COLOR' => $color,
			'LINK' => $link,
			'CHAT_ID' => $chatId,
			'USER_ID' => $userId
		);
	}
	/**
	 * @return array
	 */
	public function getAttachData()
	{
		return $this->arGridItems;
	}

	/**
	 * @return string
	 */
	public function getAttachTypeCode()
	{
		return self::ATTACH_TYPE_CODE;
	}
}