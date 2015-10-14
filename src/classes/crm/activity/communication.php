<?php

namespace Bitrix24\CRM\Activity;
use Bitrix24\Bitrix24Entity;


class Communication extends Bitrix24Entity
{
	/**
	 * get list of activity communication fields with description
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/rest_activity/crm_activity_communication_fields.php
	 * @return array
	 */
	public function fields()
	{
		$fullResult = $this->client->call(
			'crm.activity.communication.fields'
		);
		return $fullResult;
	}

}

