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
/**
 * Interface iAttach
 * @package Bitrix24\Im\Attach
 */
interface iAttach
{
	/**
	 * @var string
	 */
	const STATUS_NORMAL = "#aac337";
	/**
	 * @var string
	 */
	const STATUS_ATTENTION = "#e8a441";
	/**
	 * @var string
	 */
	const STATUS_PROBLEM = "#df532d";

	/**
	 * @return mixed
	 */
	public function setStatusNormal();

	/**
	 * @return mixed
	 */
	public function setStatusAttention();

	/**
	 * @return mixed
	 */
	public function setStatusProblem();

	/**
	 * @return array
	 */
	public function getAttachItems();
}
