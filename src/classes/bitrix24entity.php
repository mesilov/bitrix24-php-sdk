<?php
namespace Bitrix24;

use \Bitrix24\Contracts\iBitrix24;
/**
 * Class Bitrix24Entity
 */
abstract class Bitrix24Entity
{
	const ITEMS_PER_PAGE_LIMIT = 50;

	/**
	 * @var iBitrix24
	 */
	public $client = null;

	/**
	 * @param $client iBitrix24
	 */
	public function __construct(iBitrix24 $client)
	{
		$this->client = $client;
	}
}