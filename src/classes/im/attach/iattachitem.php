<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\Im\Attach;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Im\Fields as B24ImFields;

/**
 * Interface iAttachItem
 * @package Bitrix24\Im\Attach
 */
interface iAttachItem
{
	/**
	 * @return mixed
	 */
	public function getAttachData();

	/**
	 * @return string
	 */
	public function getAttachTypeCode();
}