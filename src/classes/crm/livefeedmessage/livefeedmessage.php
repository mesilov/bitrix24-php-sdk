<?php
namespace Bitrix24\CRM\LiveFeedMessage;
use Bitrix24\Bitrix24Entity;

/**
 * Class LiveFeedMessage
 * @package Bitrix24\CRM\LiveFeedMessage
 */
class LiveFeedMessage extends Bitrix24Entity
{
	/**
	 * Add message in crm feed
	 * @see http://dev.1c-bitrix.ru/rest_help/crm/livefeedmessage_add.php
	 * @param $postTitle string message title
	 * @param $message string message body
	 * @param $sperm array array of permissions
	 * @param $entityTypeId integer crm entity type identifier
	 * @param $entityId integer crm entity identifier
	 * @return array
	 */
	public function add($postTitle, $message, $sperm, $entityTypeId, $entityId)
	{
		$fullResult = $this->client->call(
			'crm.livefeedmessage.add',
			array('fields' => array(
				"POST_TITLE" => $postTitle,
				"MESSAGE" => $message,
				"SPERM" => $sperm,
				"ENTITYTYPEID" => $entityTypeId,
				"ENTITYID" => $entityId
			))
		);
		return $fullResult;
	}
}