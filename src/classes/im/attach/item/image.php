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
 * Class Image
 * @package Bitrix24\Im\Attach\Item
 */
class Image implements iAttachItem
{
	/**
	 * @var string
	 */
	const ATTACH_TYPE_CODE = 'IMAGE';
	/**
	 * @var
	 */
	protected $name;
	/**
	 * @var
	 */
	protected $link;

	/**
	 * Image constructor.
	 * @param $name
	 * @param $link
	 */
	public function __construct($name, $link)
	{
		$this->name = $name;
		$this->link = $link;
	}

	/**
	 * @return array
	 */
	public function getAttachData()
	{
		return array(
			'NAME' => $this->name,
			'LINK' => $this->link
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