<?php
namespace Bitrix24\Event;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class Event extends Bitrix24Entity
{
	/**
	 * event code when bitrix24 application has uninstall
	 */
	const ON_APP_UNINSTALL = 'ONAPPUNINSTALL';
	/**
	 * event code when bitrix24 application update
	 */
	const ON_APP_UPDATE = 'ONAPPUPDATE';
	/**
	 * event code when bitrix24 application payment
	 */
	const ON_APP_PAYMENT = 'ONAPPPAYMENT';
	/**
	 * event code when task add in bitrix24
	 */
	const ON_TASK_ADD = 'ONTASKADD';
	/**
	 * event code when task in bitrix24 has update
	 */
	const ON_TASK_UPDATE = 'ONTASKUPDATE';
	/**
	 * event code when task in bitrix24 has delete
	 */
	const ON_TASK_DELETE = 'ONTASKDELETE';
	/**
	 * event code when new user in bitrix24 has added
	 */
	const ON_USER_ADD = 'ONUSERADD';

	/**
	 * check is event handler code valid
	 * @param $eventHandlerName
	 * @return bool
	 */
	protected function isEventHandlerCodeValid($eventHandlerName)
	{
		$isEventHandlerCodeValid = false;
		switch(strtoupper($eventHandlerName))
		{
			case self::ON_APP_UPDATE:
			case self::ON_APP_PAYMENT:
			case self::ON_APP_UNINSTALL:
			case self::ON_TASK_ADD:
			case self::ON_TASK_DELETE:
			case self::ON_TASK_UPDATE:
			case self::ON_USER_ADD:
				$isEventHandlerCodeValid = true;
				break;
		}
		return $isEventHandlerCodeValid;
	}

	/**
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