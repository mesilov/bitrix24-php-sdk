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
 * Class User
 * @package Bitrix24\Im\Attach\Item
 */
class User implements iAttachItem
{
	/**
	 * @var string
	 */
	const ATTACH_TYPE_CODE = 'USER';
	/**
	 * @var
	 */
	protected $userName;
	/**
	 * @var
	 */
	protected $avatarUrl;
	/**
	 * @var
	 */
	protected $userLink;

	/**
	 * User constructor.
	 * @param $userName string required
	 * @param $avatarUrl string
	 * @param $userLink string
	 */
	public function __construct($userName, $avatarUrl = null, $userLink = null)
	{
		$this->userName = $userName;
		$this->avatarUrl = $avatarUrl;
		$this->userLink = $userLink;
	}

	/**
	 * @return array
	 */
	public function getAttachData()
	{
		return array(
			'NAME' => $this->userName,
			'AVATAR' => $this->avatarUrl,
			'LINK' => $this->userLink
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