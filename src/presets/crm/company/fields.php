<?php
namespace Bitrix24\Presets\CRM\Company;
/**
 * Class Fields
 * @link http://www.bitrixsoft.com/rest_help/crm/fields.php#company
 * @package Bitrix24\Presets\CRM\Company
 */
class Fields
{
	/**
	 * @var string Company ID. It is created automatically and is unique for the database.	Can be read, can't  write
	 */
	const ID = 'ID';	
	/**
	 * @var string Company name. A mandatory field.	Can be read, can be write
	 */
	const TITLE ='TITLE';	
	/**
	 * @var string Company type. To be selected from the list.	Can be read, can be write
	 */
	const COMPANY_TYPE ='COMPANY_TYPE';	
	/**
	 * @var string Company logo	Can be read, can be write
	 */
	const LOGO ='LOGO';	
	/**
	 * @var string Physical address	Can be read, can be write
	 */
	const ADDRESS ='ADDRESS';	
	/**
	 * @var string Legal address	Can be read, can be write
	 */
	const ADDRESS_LEGAL = 'ADDRESS_LEGAL';	
	/**
	 * @var string Bank details	Can be read, can be write
	 */
	const BANKING_DETAILS = 'BANKING_DETAILS';	
	/**
	 * @var string Area of activity. To be selected from the list.	Can be read, can be write
	 */
	const INDUSTRY = 'INDUSTRY';	
	/**
	 * @var string Number of employees. To be selected from the list.	Can be read, can be write
	 */
	const EMPLOYEES = 'EMPLOYEES';	
	/**
	 * @var string Settlement currency	Can be read, can be write
	 */
	const CURRENCY_ID = 'CURRENCY_ID';	
	/**
	 * @var string Annual turnover	Can be read, can be write
	 */
	const REVENUE = 'REVENUE';	
	/**
	 * @var string Check mark "Available for all"	Can be read, can be write
	 */
	const OPENED = 'OPENED';	
	/**
	 * @var string Comments	Can be read, can be write
	 */
	const COMMENTS = 'COMMENTS';	
	/**
	 * @var string Responsible person’s ID	Can be read, can be write
	 */
	const ASSIGNED_BY_ID = 'ASSIGNED_BY_ID';
	/**
	 * @var string Created by	Can be read, can't  write
	 */
	const CREATED_BY_ID = 'CREATED_BY_ID';	
	/**
	 * @var string Modified by	Can be read, can't  write
	 */
	const MODIFY_BY_ID = 'MODIFY_BY_ID';
	/**
	 * @var string Creation date. Can be read, can't  write
	 */
	const DATE_CREATE = 'DATE_CREATE';	
	/**
	 * @var string Modification date. Can be read, can't  write
	 */
	const DATE_MODIFY = 'DATE_MODIFY';	
	/**
	 * @var string 	Lead ID	Can be read, can't  write
	 */
	const LEAD_ID = 'LEAD_ID';
	/**
	 * @var string ID of the external information database. The field assignment can be modified by the end developer.	Can be read, can be write
	 */
	const ORIGINATOR_ID = 'ORIGINATOR_ID';	
	/**
	 * @var string External key that is used for exchange operations. ID of an object of the external information database. The field assignment can be modified by the end developer.	Can be read, can be write
	 */
	const ORIGIN_ID = 'ORIGIN_ID';	
	/**
	 * @var string Phone. Can be read, can be write
	 */
	const PHONE = 'PHONE';	
	/**
	 * @var string E-mail. Can be read, can be write
	 */
	const EMAIL = 'EMAIL';	
	/**
	 * @var string 	Website	Can be read, can be write
	 */
	const WEB = 'WEB';
	/**
	 * @var string Contact person in the instant messaging service.	Can be read, can be write
	 */
	const IM = 'IM';
}