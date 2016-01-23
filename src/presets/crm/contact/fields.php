<?php

namespace Bitrix24\Presets\CRM\Contact;

/**
 * Class Fields.
 *
 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_fields.php
 */
class fields
{
    /**
     * @var int ID - GUID contact identifier, created automatically. Can be read and write.
     */
    const    ID = 'ID';

    /**
     * @var string NAME - Name of contact, required. Can be read and write.
     */
    const    NAME = 'NAME';

    /**
     * @var string SECOND_NAME - Second name of contact, required. Can be read and write.
     */
    const    SECOND_NAME = 'SECOND_NAME';

    /**
     * @var string LAST_NAME - Last name of contact, required. Can be read and write.
     */
    const    LAST_NAME = 'LAST_NAME';

    /**
     * @var string PHOTO - Photo of contact. Can be read and write.
     */
    const    PHOTO = 'PHOTO';

    /**
     * @var \DateTime BIRTHDATE - Contact birthdate. Can be read and write.
     */
    const    BIRTHDATE = 'BIRTHDATE';

    /**
     * @var crm_status TYPE_ID - Contact type. Can be read and write.
     */
    const    TYPE_ID = 'TYPE_ID';

    /**
     * @var crm_status SOURCE_ID - Contact source. Can be read and write.
     */
    const    SOURCE_ID = 'SOURCE_ID';

    /**
     * @var string SOURCE_DESCRIPTION - Contact source description, сan be read and write.
     */
    const    SOURCE_DESCRIPTION = 'SOURCE_DESCRIPTION';

    /**
     * @var string POST - Contact post, сan be read and write.
     */
    const    POST = 'POST';

    /**
     * @var string ADDRESS - Contact address, сan be read and write.
     */
    const    ADDRESS = 'ADDRESS';

    /**
     * @var string OPENED - is contact opened for all users, сan be read and write.
     */
    const    OPENED = 'OPENED';

    /**
     * @var string COMMENTS - comments for contact, сan be read and write.
     */
    const    COMMENTS = 'COMMENTS';

    /**
     * @var string EXPORT - is contact can be exported from crm, сan be read and write.
     */
    const    EXPORT = 'EXPORT';

    /**
     * @var int ASSIGNED_BY_ID - identifier of responsible user for this contact, read only.
     */
    const    ASSIGNED_BY_ID = 'ASSIGNED_BY_ID';

    /**
     * @var int CREATED_BY_ID - identifier of user who created this contact, read only.
     */
    const    CREATED_BY_ID = 'CREATED_BY_ID';

    /**
     * @var int MODIFY_BY_ID - identifier of last user who modify this contact, read only.
     */
    const    MODIFY_BY_ID = 'MODIFY_BY_ID';

    /**
     * @var \DateTime DATE_CREATE - date create this contact, read only.
     */
    const    DATE_CREATE = 'DATE_CREATE';

    /**
     * @var \DateTime DATE_MODIFY - date modify this contact, read only.
     */
    const    DATE_MODIFY = 'DATE_MODIFY';

    /**
     * @var crm_company COMPANY_ID - crm company identifier, сan be read and write.
     */
    const    COMPANY_ID = 'COMPANY_ID';

    /**
     * @var crm_lead LEAD_ID - lead identifier, read only.
     */
    const    LEAD_ID = 'LEAD_ID';

    /**
     * @var crm_multifield PHONE - contact phone, сan be read and write.
     */
    const    PHONE = 'PHONE';

    /**
     * @var crm_multifield EMAIL - contact email, сan be read and write.
     */
    const    EMAIL = 'EMAIL';

    /**
     * @var crm_multifield WEB - contact web-site, сan be read and write.
     */
    const    WEB = 'WEB';

    /**
     * @var crm_multifield IM - contact instant messenger nick, сan be read and write.
     */
    const    IM = 'IM';

    /**
     * @var string ORIGINATOR_ID - identifier external informaton sistem. Only for dewelopers, сan be read and write.
     */
    const    ORIGINATOR_ID = 'ORIGINATOR_ID';

    /**
     * @var string ORIGIN_ID - extertal key for exchange operations with other systems. Only for dewelopers, сan be read and write.
     */
    const    ORIGIN_ID = 'ORIGIN_ID';
}
