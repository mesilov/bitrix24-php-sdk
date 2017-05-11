<?php

namespace Bitrix24\Presets\CRM\Contact;
/**
 * Class Fields
 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_fields.php
 * @package Bitrix24\Presets\CRM\Contact
 */
class Fields
{
    /**
     * @var string ADDRESS Contact address, сan be read and write.
     */
    const ADDRESS = 'ADDRESS';
    /**
     * @var string Address Can be read, can be write
     */
    const ADDRESS_APARTMENT = 'ADDRESS_2';
    /**
     * @var string Address Can be read, can be write
     */
    const ADDRESS_CITY = 'ADDRESS_CITY';
    /**
     * @var string Address Can be read, can be write
     */
    const ADDRESS_COUNTRY = 'ADDRESS_COUNTRY';
    /**
     * @var string Address Can be read, can be write
     */
    const ADDRESS_COUNTRY_CODE = 'ADDRESS_COUNTRY_CODE';
    /**
     * @var string Address Can be read, can be write
     */
    const ADDRESS_POSTAL_CODE = 'ADDRESS_POSTAL_CODE';
    /**
     * @var string Address Can be read, can be write
     */
    const ADDRESS_PROVINCE = 'ADDRESS_PROVINCE';
    /**
     * @var string Address Can be read, can be write
     */
    const ADDRESS_REGION = 'ADDRESS_REGION';
    /**
     * @var integer ASSIGNED_BY_ID - identifier of responsible user for this contact, Can be read and write.
     */
    const ASSIGNED_BY_ID = 'ASSIGNED_BY_ID';
    /**
     * @var string BIRTHDATE - Contact birthdate. Can be read and write.
     */
    const BIRTHDATE = 'BIRTHDATE';
    /**
     * @var string COMMENTS - comments for contact, сan be read and write.
     */
    const COMMENTS = 'COMMENTS';
    /**
     * @var string COMPANY_ID - crm company identifier, сan be read and write.
     */
    const COMPANY_ID = 'COMPANY_ID';
    /**
     * @var string CREATED_BY_ID - identifier of user who created this contact, read only.
     */
    const CREATED_BY_ID = 'CREATED_BY_ID';
    /**
     * @var string DATE_CREATE - \DateTime create this contact, read only.
     */
    const DATE_CREATE = 'DATE_CREATE';
    /**
     * @var string DATE_MODIFY -  \DateTime date modify this contact, read only.
     */
    const DATE_MODIFY = 'DATE_MODIFY';
    /**
     * @var string EMAIL - crm_multifield contact email, сan be read and write.
     */
    const EMAIL = 'EMAIL';
    /**
     * @var string EXPORT - is contact can be exported from crm, сan be read and write.
     */
    const EXPORT = 'EXPORT';
    /**
     * @var string сan be read and write.
     */
    const HAS_EMAIL = 'HAS_EMAIL';
    /**
     * @var string сan be read and write.
     */
    const HAS_PHONE = 'HAS_PHONE';
    /**
     * @var string сan be read and write.
     */
    const HONORIFIC = 'HONORIFIC';
    /**
     * @var string ID - GUID contact identifier, created automatically. Can be read and write.
     */
    const ID = 'ID';
    /**
     * @var string crm_multifield  contact instant messenger nick, сan be read and write
     */
    const IM = 'IM';
    /**
     * @var string LAST_NAME - Last name of contact, required. Can be read and write.
     */
    const LAST_NAME = 'LAST_NAME';
    /**
     * @var string LEAD_ID - lead identifier, read only.
     */
    const LEAD_ID = 'LEAD_ID';
    /**
     * @var string MODIFY_BY_ID - identifier of last user who modify this contact, read only.
     */
    const MODIFY_BY_ID = 'MODIFY_BY_ID';
    /**
     * @var string NAME - Name of contact, required. Can be read and write.
     */
    const NAME = 'NAME';
    /**
     * @var string OPENED - is contact opened for all users, сan be read and write.
     */
    const OPENED = 'OPENED';
    /**
     * @var string ORIGINATOR_ID - identifier external information system. Only for developers, сan be read and write.
     */
    const ORIGINATOR_ID = 'ORIGINATOR_ID';
    /**
     * @var string ORIGIN_ID - extertal key for exchange operations with other systems. Only for dewelopers, сan be read and write.
     */
    const ORIGIN_ID = 'ORIGIN_ID';
    /**
     * @var string
     */
    const ORIGIN_VERSION = 'ORIGIN_VERSION';
    /**
     * @var string crm_multifield PHONE - contact phone, сan be read and write.
     */
    const PHONE = 'PHONE';
    /**
     * @var string PHOTO - Photo of contact. Can be read and write.
     */
    const PHOTO = 'PHOTO';
    /**
     * @var string POST - Contact post, сan be read and write.
     */
    const POST = 'POST';
    /**
     * @var string SECOND_NAME - Second name of contact, required. Can be read and write.
     */
    const SECOND_NAME = 'SECOND_NAME';
    /**
     * @var string SOURCE_DESCRIPTION - Contact source description, сan be read and write.
     */
    const SOURCE_DESCRIPTION = 'SOURCE_DESCRIPTION';
    /**
     * @var string SOURCE_ID - Contact source. Can be read and write.
     */
    const SOURCE_ID = 'SOURCE_ID';
    /**
     * @var string crm_status TYPE_ID - Contact type. Can be read and write.
     */
    const TYPE_ID = 'TYPE_ID';
    /**
     * @var string Can be read and write.
     */
    const UTM_CAMPAIGN = 'UTM_CAMPAIGN';
    /**
     * @var string Can be read and write.
     */
    const UTM_CONTENT = 'UTM_CONTENT';
    /**
     * @var string Can be read and write.
     */
    const UTM_MEDIUM = 'UTM_MEDIUM';
    /**
     * @var string Can be read and write.
     */
    const UTM_SOURCE = 'UTM_SOURCE';
    /**
     * @var string Can be read and write.
     */
    const UTM_TERM = 'UTM_TERM';
    /**
     * @var string crm_multifield WEB - contact web-site, сan be read and write.
     */
    const WEB = 'WEB';
}