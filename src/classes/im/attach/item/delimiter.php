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
 * Class Delimiter
 * @package Bitrix24\Im\Attach\Item
 */
class Delimiter implements iAttachItem
{
	/**
	 * @var string
	 */
	const ATTACH_TYPE_CODE = 'DELIMITER';
	/**
	 * @var
	 */
	protected $color;
	/**
	 * @var
	 */
	protected $size;

	/**
	 * Delimiter constructor.
	 * @param $size
	 * @param $color
	 */
	public function __construct($size = null, $color = null)
	{
		$this->size = $size;
		$this->color = $color;
	}

	/**
	 * @return array
	 */
	public function getAttachData()
	{
		return array(
			'SIZE' => $this->size,
			'COLOR' => $this->color,
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