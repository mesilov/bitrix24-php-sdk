<?php
namespace Bitrix24\Presets\CRM\Additional\Duplicate;
/**
 * Class EntityTypes
 * @link https://training.bitrix24.com/rest_help/crm/auxiliary/duplicates/crm.duplicate.findbycomm.php
 * @package Bitrix24\Presets\CRM\Additional\Duplicate
 */
class EntityTypes
{
	/**
	 * @var string specifies the type of communication to search by email
	 */
	const COMMUNICATION_BY_EMAIL = 'EMAIL';
	/**
	 * @var string specifies the type of communication to search by phone
	 */
	const COMMUNICATION_BY_PHONE = 'PHONE';
	/**
	 * @var string specifies the type of entities to search - leads
	 */
	const ENTITY_TYPE_LEAD = 'LEAD';
	/**
	 * @var string specifies the type of entities to search - contacts
	 */
	const ENTITY_TYPE_CONTACT = 'CONTACT';
	/**
	 * @var string specifies the type of entities to search - companies
	 */
	const ENTITY_TYPE_COMPANY = 'COMPANY';
}