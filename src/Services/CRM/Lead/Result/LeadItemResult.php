<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Lead\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Email;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\InstantMessenger;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Phone;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Website;
use DateTimeInterface;

/**
 * Class LeadItemResult
 *
 * @property-read int                    $ID
 * @property-read string                 $TITLE
 * @property-read string                 $HONORIFIC
 * @property-read string                 $NAME
 * @property-read string                 $SECOND_NAME
 * @property-read string                 $LAST_NAME
 * @property-read DateTimeInterface|null $BIRTHDATE
 * @property-read string                 $COMPANY_TITLE
 * @property-read string                 $SOURCE_ID
 * @property-read string                 $SOURCE_DESCRIPTION
 * @property-read string                 $STATUS_ID
 * @property-read string                 $STATUS_DESCRIPTION
 * @property-read string                 $STATUS_SEMANTIC_ID
 * @property-read string                 $POST
 * @property-read string                 $ADDRESS
 * @property-read string                 $ADDRESS_2
 * @property-read string                 $ADDRESS_CITY
 * @property-read string                 $ADDRESS_POSTAL_CODE
 * @property-read string                 $ADDRESS_REGION
 * @property-read string                 $ADDRESS_PROVINCE
 * @property-read string                 $ADDRESS_COUNTRY
 * @property-read string                 $ADDRESS_COUNTRY_CODE
 * @property-read int                    $ADDRESS_LOC_ADDR_ID
 * @property-read string                 $CURRENCY_ID
 * @property-read string                 $OPPORTUNITY
 * @property-read string                 $IS_MANUAL_OPPORTUNITY
 * @property-read string                 $OPENED
 * @property-read string                 $COMMENTS
 * @property-read string                 $HAS_PHONE
 * @property-read string                 $HAS_EMAIL
 * @property-read string                 $HAS_IMOL
 * @property-read string                 $ASSIGNED_BY_ID
 * @property-read string                 $CREATED_BY_ID
 * @property-read string                 $MODIFY_BY_ID
 * @property-read string                 $MOVED_BY_ID
 * @property-read string                 $DATE_CREATE
 * @property-read string                 $DATE_MODIFY
 * @property-read string                 $MOVED_TIME
 * @property-read string                 $COMPANY_ID
 * @property-read string                 $CONTACT_ID
 * @property-read string                 $CONTACT_IDS
 * @property-read string                 $IS_RETURN_CUSTOMER
 * @property-read string                 $DATE_CLOSED
 * @property-read string                 $ORIGINATOR_ID
 * @property-read string                 $ORIGIN_ID
 * @property-read string                 $UTM_SOURCE
 * @property-read string                 $UTM_MEDIUM
 * @property-read string                 $UTM_CAMPAIGN
 * @property-read string                 $UTM_CONTENT
 * @property-read string                 $UTM_TERM
 * @property-read Phone[]                $PHONE
 * @property-read Email[]                $EMAIL
 * @property-read Website[]              $WEB
 * @property-read InstantMessenger[]     $IM
 * @property-read string                 $LINK
 */
class LeadItemResult extends AbstractCrmItem
{
    /**
     * @param string $userfieldName
     *
     * @return mixed|null
     * @throws \Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException
     */
    public function getUserfieldByFieldName(string $userfieldName)
    {
        return $this->getKeyWithUserfieldByFieldName($userfieldName);
    }
}