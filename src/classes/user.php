<?php
namespace Bitrix24\User;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class User extends Bitrix24Entity
{
	/**
	 * Get information about current user by his auth information
	 * @link http://dev.1c-bitrix.ru/rest_help/users/user_current.php
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function current()
	{
		$result = $this->client->call('user.current');
		return $result;
	}

	/**
	 * Get list of fields entity user
	 * @link http://dev.1c-bitrix.ru/rest_help/users/user_fields.php
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function fields()
	{
		$result = $this->client->call('user.fields');
		return $result;
	}
}