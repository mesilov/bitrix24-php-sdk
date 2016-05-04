<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\Im\Attach;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Im\Fields as B24ImFields;
use Bitrix24\Im\Attach\iAttachItem;

/**
 * Class Attach
 * @package Bitrix24\Im\Attach
 */
class Attach implements iAttach
{
	/**
	 * @var string
	 */
	const CHAT = 'CHAT';
	/**
	 * @var int $id Unix timestamp
	 */
	protected $id;
	/**
	 * @var string $color hex color see iAttach interface
	 */
	protected $color;
	/**
	 * @var array
	 */
	protected $attachItems;
	/**
	 * Attach constructor.
	 * @param null | int $id Unix timestamp
	 * @param null | string $color hex color see iAttach interface
	 */
	public function __construct($id = null, $color = null)
	{
		$this->attachItems = array();

		if(null === $id)
		{
			$this->id = time();
		}

		if (self::CHAT !== $color)
		{
			$this->color = $color;
			if(null === $this->color)
			{
				$this->setStatusNormal();
			}
		}
	}

	/**
	 * @param iAttachItem $attachItem
	 */
	public function add(iAttachItem $attachItem)
	{
		$this->attachItems[] = clone $attachItem;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return array(
			'ID' => $this->id,
			'BLOCKS' => $this->getAttachList(),
			'COLOR' => $this->color
		);
	}

	/**
	 * @return array
	 */
	public function getAttachItems()
	{
		return $this->attachItems;
	}

	/**
	 * @return array
	 */
	private function getAttachList()
	{
		$arResult = array();
		/**
		 * @var $obAttachItem iAttachItem
		 */
		foreach($this->getAttachItems() as $cnt => $obAttachItem)
		{
			$arResult[][$obAttachItem->getAttachTypeCode()] = $obAttachItem->getAttachData();
		}
		return $arResult;
	}

	/**
	 * @return mixed
	 */
	public function setStatusNormal()
	{
		$this->color = self::STATUS_NORMAL;
	}

	/**
	 * @return mixed
	 */
	public function setStatusAttention()
	{
		$this->color = self::STATUS_ATTENTION;
	}

	/**
	 * @return mixed
	 */
	public function setStatusProblem()
	{
		$this->color = self::STATUS_PROBLEM;
	}
}