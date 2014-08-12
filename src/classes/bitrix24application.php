<?php

namespace Bitrix24\Application;
/**
 * Class Application
 * @package Bitrix24\Application
 */
class Application
{
	/**
	 * @var array fields in request from bitrix24 application loaded in iframe
	 */
	private static $requirementFieldsInRequest = array(
		'DOMAIN',
		'PROTOCOL',
		'LANG',
		'APP_SID',
		'AUTH_ID',
		'AUTH_EXPIRES',
		'REFRESH_ID',
		'member_id'
	);
	/**
	 * check http request from bitrix24 bitrix24 application loaded in iframe for requirement fields
	 * @param $request
	 * @return bool
	 */
	public static function isRequestValid($request)
	{
		$isRequestValid = false;
		$requestKeys = array_map('strtoupper',array_keys($request));
		$requirementFieldsInRequest = array_map('strtoupper', self::$requirementFieldsInRequest);
		if(count(array_diff($requirementFieldsInRequest, $requestKeys)) == 0)
		{
			$isRequestValid = true;
		}
		return $isRequestValid;
	}
}