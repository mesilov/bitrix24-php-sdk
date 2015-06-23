<?php
namespace Bitrix24\Presets\CRM\Lead;

/**
 * Class Fields
 * @link http://www.bitrixsoft.com/rest_help/crm/leads/crm_lead_fields.php
 * @package Bitrix24\Presets\CRM\Lead
 * @todo check fields
 */
class Fields
{
	/**
	 * @var integer Lead ID, can be read, can't write
	 */
	const ID = 'ID';
	/**
	 * @var string Lead name. A mandatory field. Can be read, can be write
	 */
	const TITLE = 'TITLE';
	/**
	 * @var string Contact person’s name	. Can be read, can be write
	 */
	const NAME = 'NAME';
	/**
	 * @var string Contact person’s patronymic.	Can be read, can be write
	 */
	const SECOND_NAME = 'SECOND_NAME';
	/**
	 * @var string Last name. Can be read, can be write
	 */
	const LAST_NAME = 'LAST_NAME';
	/**
	 * @var string Company name. Can be read, can be write
	 */
	const COMPANY_TITLE = 'COMPANY_TITLE';
	/**
	 * @var integer  Source identifier.  Can be read, can be write
	 */
	const SOURCE_ID = 'SOURCE_ID';
	/**
	 * @var string 	Additional information about the source. Can be read, can be write
	 */
	const SOURCE_DESCRIPTION = 'SOURCE_DESCRIPTION';
	/**
	 * @var string Lead status ID. Can be read, can be write
	 */
	const STATUS_ID = 'STATUS_ID';
	/**
	 * @var string Additional information about the status. Can be read, can be write
	 */
	const STATUS_DESCRIPTION = 'STATUS_DESCRIPTION';
	/**
	 * @var string Position in company structure. Can be read, can be write
	 */
	const POST = 'POST';
	/**
	 * @var string 	Address	Can be read, can be write
	 */
	const  ADDRESS = 'ADDRESS';
	/**
	 * @var string 	Address	Can be read, can be write
	 */
	const  ADDRESS_APARTMENT = 'ADDRESS_2';
	/**
	 * @var integer Currency ID	Can be read, can be write
	 */
	const CURRENCY_ID = 'CURRENCY_ID';
	/**
	 * @var float Supposed amount Can be read, can be write
	 */
	const OPPORTUNITY = 'OPPORTUNITY';
	/**
	 * @var string Checkmark "Available for all" Can be read, can be write
	 */
	const OPENED = 'OPENED';
	/**
	 * @var string Comments	Can be read, can be write
	 */
	const COMMENTS = 'COMMENTS';
	/**
	 * @var integer Responsible person	Can be read, can be write
	 */
	const ASSIGNED_BY_ID = 'ASSIGNED_BY_ID';
	/**
	 * @var integer Created by	Can be read, can't write
	 */
	const CREATED_BY_ID = 'CREATED_BY_ID';
	/**
	 * @var integer Modified by	Can be read, can't write
	 */
	const MODIFY_BY_ID = 'MODIFY_BY_ID';
	/**
	 * @var \DateTime Creation date	Can be read, can't write
	 */
	const DATE_CREATE = 'DATE_CREATE';
	/**
	 * @var \DateTime Modification date	Can be read, can't write
	 */
	const DATE_MODIFY = 'DATE_MODIFY';
	/**
	 * @var integer Company ID	Can be read, can't write
	 */
	const COMPANY_ID = 'COMPANY_ID';
	/**
	 * @var integer Contact person’s ID	Can be read, can't write
	 */
	const CONTACT_ID = 'CONTACT_ID';
	/**
	 * @var \DateTime Closing date. Can be read, can't write
	 */
	const DATE_CLOSED = 'DATE_CLOSED';
	/**
	 * @var string Phone. Can be read, can be write
	 */
	const PHONE = 'PHONE';
	/**
	 * @var string E-mail. Can be read, can be write
	 */
	const EMAIL = 'EMAIL';
	/**
	 * @var string Website	Can be read, can be write
	 */
	const WEB = 'WEB';
	/**
	 * @var string Contact person in the instant messaging service	Can be read, can be write
	 */
	const IM = 'IM';
	/**
	 * @var string External information base ID. Field assignment can be changed by the end developer. Can be read, can be write
	 */
	const ORIGINATOR_ID = 'ORIGINATOR_ID';
	/**
	 * @var string External key that is used for exchange operations. ID of an object of the external information database. The field assignment can be modified by the end developer. Can be read, can be write
	 */
	const ORIGIN_ID = 'ORIGIN_ID';
}