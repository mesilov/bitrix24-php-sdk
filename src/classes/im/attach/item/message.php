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
 * Class Message
 * @package Bitrix24\Im\Attach\Item
 */
class Message implements iAttachItem
{
	/**
	 * @var string
	 */
	const ATTACH_TYPE_CODE = 'MESSAGE';
	/**
	 * @var
	 */
	protected $message;

	/**
	 * Message constructor.
	 * @param $message
	 */
	public function __construct($message)
	{
		$this->message = $message;
	}

	/**
	 * @return array
	 */
	public function getAttachData()
	{
		return $this->message;
	}

	/**
	 * @return string
	 */
	public function getAttachTypeCode()
	{
		return self::ATTACH_TYPE_CODE;
	}
}