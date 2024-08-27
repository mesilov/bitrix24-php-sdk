<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Contact\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Email;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\InstantMessenger;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Phone;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Website;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException;
use Carbon\CarbonImmutable;

/**
 * @property-read int $ADDRESS_LOC_ADDR_ID
 * @property-read string|null $ADDRESS
 * @property-read string|null $ADDRESS_2
 * @property-read string|null $ADDRESS_CITY
 * @property-read string|null $ADDRESS_COUNTRY
 * @property-read string|null $ADDRESS_COUNTRY_CODE
 * @property-read string|null $ADDRESS_POSTAL_CODE
 * @property-read string|null $ADDRESS_PROVINCE
 * @property-read string|null $ADDRESS_REGION
 * @property-read int $ASSIGNED_BY_ID
 * @property-read CarbonImmutable|null $BIRTHDATE
 * @property-read string|null $COMMENTS
 * @property-read int|null $COMPANY_ID
 * @property-read array<int,int>|null $COMPANY_IDS
 * @property-read int $CREATED_BY_ID
 * @property-read CarbonImmutable $DATE_CREATE
 * @property-read CarbonImmutable $DATE_MODIFY
 * @property-read int|null $FACE_ID
 * @property-read bool $EXPORT
 * @property-read Email[] $EMAIL
 * @property-read int $ID
 * @property-read bool $HAS_EMAIL
 * @property-read bool $HAS_IMOL
 * @property-read bool $HAS_PHONE
 * @property-read string|null $HONORIFIC
 * @property-read InstantMessenger[] $IM
 * @property-read int|null $LEAD_ID
 * @property-read CarbonImmutable $LAST_ACTIVITY_TIME
 * @property-read int $LAST_ACTIVITY_BY
 * @property-read string|null $LAST_NAME
 * @property-read string|null $LINK
 * @property-read int $MODIFY_BY_ID
 * @property-read string $NAME
 * @property-read string|null $ORIGIN_ID
 * @property-read string|null $ORIGINATOR_ID
 * @property-read string|null $ORIGIN_VERSION
 * @property-read string $OPENED
 * @property-read Phone[] $PHONE
 * @property-read string|null $POST
 * @property-read string|null $PHOTO
 * @property-read string|null $SECOND_NAME
 * @property-read string|null $SOURCE_DESCRIPTION
 * @property-read string|null $SOURCE_ID
 * @property-read string|null $TYPE_ID
 * @property-read string|null $UTM_CAMPAIGN
 * @property-read string|null $UTM_CONTENT
 * @property-read string|null $UTM_MEDIUM
 * @property-read string|null $UTM_SOURCE
 * @property-read string|null $UTM_TERM
 * @property-read Website[] $WEB
 */
class ContactItemResult extends AbstractCrmItem
{
    /**
     * @param string $userfieldName
     *
     * @return mixed|null
     * @throws UserfieldNotFoundException
     */
    public function getUserfieldByFieldName(string $userfieldName): mixed
    {
        return $this->getKeyWithUserfieldByFieldName($userfieldName);
    }
}