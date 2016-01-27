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
 * Class Link
 * @package Bitrix24\Im\Attach\Item
 */
class Link implements iAttachItem
{
	/**
	 * @var string
	 */
	const ATTACH_TYPE_CODE = 'LINK';
	/**
	 * @var
	 */
	protected $name;
	/**
	 * @var
	 */
	protected $description;
	/**
	 * @var
	 */
	protected $link;
	/**
	 * @var string
	 */
	protected $preview;

	/**
	 * Link constructor.
	 * @param $name string required
	 * @param $link string required
	 * @param $description string
	 * @param $preview string required
	 */
	public function __construct($name, $link, $description, $preview)
	{
		$this->name = $name;
		$this->link = $link;
		$this->description = $description;
		$this->preview = $preview;
	}

	/**
	 * @return array
	 */
	public function getAttachData()
	{
		return array(
			'NAME' => $this->name,
			'DESC' => $this->description,
			'LINK' => $this->link,
			'PREVIEW' => $this->preview
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