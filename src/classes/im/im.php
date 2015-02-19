<?php
namespace Bitrix24\Im;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class Im
 * @package Bitrix24\Im
 */
class Im extends Bitrix24Entity
{
	/**
	 * send notification to user
	 * @param $userId integer bitrix24 user identifier
	 * @param $message string message to user, support some html tags
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function notify($userId, $message)
	{
		if(is_null($userId))
		{
			throw new Bitrix24Exception('user id is null');
		}
		elseif(is_null($message))
		{
			throw new Bitrix24Exception('message is null');
		}

		$fullResult = $this->client->call(
			'im.notify',
			array(
				'to' => $userId,
				'message' => $message
			)
		);
		return $fullResult;
	}
}