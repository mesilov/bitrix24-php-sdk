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
 * Class File
 * @package Bitrix24\Im\Attach\Item
 */
class File implements iAttachItem
{
	/**
	 * @var string
	 */
	const ATTACH_TYPE_CODE = 'FILE';
	/**
	 * @var
	 */
	protected $name;
	/**
	 * @var
	 */
	protected $link;
	/**
	 * @var
	 */
	protected $size;

	/**
	 * Image constructor.
	 * @param $name
	 * @param $link
	 * @param $size
	 */
	public function __construct($link, $name, $size)
	{
		$this->name = $name;
		$this->link = $link;
		$this->size = $size;
	}

	/**
	 * @return array
	 */
	public function getAttachData()
	{
		return array(
			'NAME' => $this->name,
			'LINK' => $this->link,
			'SIZE' => $this->size,
		);
	}

	/**
	 * @return string
	 */
	public function getAttachTypeCode()
	{
		return self::ATTACH_TYPE_CODE;
	}
}