<?php
namespace Bitrix24\Event;

/**
 * Class Util
 * @package Bitrix24\Event
 */
class Util
{
	/**
	 *
	 * @param $arEvents
	 * @param $newEventName
	 * @param $newEventHandler
	 * @return bool
	 */
	public static function isEventBind($arEvents, $newEventName, $newEventHandler)
	{
		$isEventBind = false;
		foreach($arEvents as $cnt => $arEvent)
		{
			if(($arEvent['event'] === $newEventName) && ($arEvent['handler'] === $newEventHandler))
			{
				$isEventBind = true;
			}
		}
		return $isEventBind;
	}
}
