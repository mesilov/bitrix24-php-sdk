<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Contact\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use DateTimeInterface;

/**
 * Class ContactItemResult
 *
 * @property-read int                    $ID
 * @property-read string                 $HONORIFIC
 * @property-read string                 $NAME
 * @property-read string                 $SECOND_NAME
 * @property-read string                 $LAST_NAME
 * @property-read string                 $PHOTO
 * @property-read null|DateTimeInterface $BIRTHDATE
 * @property-read string                 $TYPE_ID
 * @property-read string                 $SOURCE_ID
 * @property-read string                 $SOURCE_DESCRIPTION
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
 * @property-read string                 $COMMENTS
 * @property-read string                 $OPENED
 * @property-read bool                   $EXPORT
 * @property-read string                 $HAS_PHONE
 * @property-read string                 $HAS_EMAIL
 * @property-read string                 $HAS_IMOL
 * @property-read int                    $ASSIGNED_BY_ID
 * @property-read int                    $CREATED_BY_ID
 * @property-read int                    $MODIFY_BY_ID
 * @property-read DateTimeInterface      $DATE_CREATE
 * @property-read DateTimeInterface      $DATE_MODIFY
 * @property-read string                 $COMPANY_ID
 * @property-read string                 $COMPANY_IDS
 * @property-read string                 $LEAD_ID
 * @property-read string                 $ORIGINATOR_ID
 * @property-read string                 $ORIGIN_ID
 * @property-read string                 $ORIGIN_VERSION
 * @property-read int                    $FACE_ID
 * @property-read string                 $UTM_SOURCE
 * @property-read string                 $UTM_MEDIUM
 * @property-read string                 $UTM_CAMPAIGN
 * @property-read string                 $UTM_CONTENT
 * @property-read string                 $UTM_TERM
 * @property-read string                 $PHONE
 * @property-read string                 $EMAIL
 * @property-read string                 $WEB
 * @property-read string                 $IM
 */
class ContactItemResult extends AbstractCrmItem
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