<?php
namespace Bitrix24\Event;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Event\Event as EventType;

/**
 * Class Event
 * @package Bitrix24\Event
 */
class Event extends Bitrix24Entity
{
	/**
	 * check is event handler code valid
	 * @param $eventHandlerName
	 * @return bool
	 */
	protected function isEventHandlerCodeValid($eventHandlerName)
	{
        $reflection = new \ReflectionClass('\Bitrix24\Presets\Event\Event');
        $result = $reflection->getConstant(strtoupper($eventHandlerName));
        return isset($result);
	}

	/**
	 * Get list of register events
	 * @return array
	 */
	public function get()
	{
		$fullResult = $this->client->call(
			'event.get',
			array()
		);
		return $fullResult;
	}

	/**
	 * Get list of all supported events
	 * @link http://dev.1c-bitrix.ru/rest_help/general/events.php
	 * @return array
	 */
	public function getList()
	{
		$fullResult = $this->client->call(
			'events',
			array()
		);
		return $fullResult;
	}
	/**
	 * Register new event handler. Work only for user with portal administrator rights
	 * @link http://dev.1c-bitrix.ru/rest_help/general/event_bind.php
	 * @param $eventName string event handler code
	 * @param $handler string event handler URL
	 * @param $authType integer user identifier, under witch event handler was executed
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function bind($eventName, $handler, $authType = null)
	{
		if(!$this->isEventHandlerCodeValid($eventName))
		{
			throw new Bitrix24Exception('eventName is invalid');
		}
		if(is_null($handler))
		{
			throw new Bitrix24Exception('handler URL is null');
		}
		$fullResult = $this->client->call(
			'event.bind',
			array(
				'event' => $eventName,
				'handler' => $handler,
				'auth_type' => $authType
			)
		);
		return $fullResult;
	}

	/**
	 * Unregister event handler. Work only for user with portal administrator rights
	 * @link http://dev.1c-bitrix.ru/rest_help/general/event_unbind.php
	 * @param $eventName
	 * @param $handler
	 * @param null $authType
	 * @return array
	 */
	public function unbind($eventName = NULL, $handler = NULL, $authType = null)
	{
		$fullResult = $this->client->call(
			'event.unbind',
			array(
				'event' => $eventName,
				'handler' => $handler,
				'auth_type' => $authType
			)
		);
		return $fullResult;
	}
}