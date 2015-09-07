<?php
namespace Bitrix24\CRM\Additional;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

/**
 * Class Duplicate
 * @package Bitrix24\CRM
 */
class Duplicate extends Bitrix24Entity
{
	/**
	 * The method returns the ID's of the leads, contacts or companies that contain the specified phone numbers or e-mails.
	 * @param $communicationType string "EMAIL" or "PHONE", required
	 * @param $arValues array containing up to 20 e-mails or phone numbers, required.
	 * @param $entityType string specifies the type of entities to search "LEAD", "CONTACT", "COMPANY"
	 * @return array
	 * @link https://training.bitrix24.com/rest_help/crm/auxiliary/duplicates/crm.duplicate.findbycomm.php
	 */
	public function findByComm($communicationType, $arValues, $entityType = null)
	{
		$result = $this->client->call('crm.duplicate.findbycomm',
			array(
				'type' => $communicationType,
				'values'=> $arValues,
				'entity_type'=> $entityType,
			)
		);
		return $result;
	}
}