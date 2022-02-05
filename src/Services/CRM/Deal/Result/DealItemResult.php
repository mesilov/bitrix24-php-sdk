<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use DateTimeInterface;

/**
 * Class DealItemResult
 *
 * @property-read int               $ID
 * @property-read string            $TITLE deal title
 * @property-read string|null       $TYPE_ID
 * @property-read string|null       $CATEGORY_ID
 * @property-read string            $STAGE_ID
 * @property-read string            $STAGE_SEMANTIC_ID
 * @property-read bool              $IS_NEW
 * @property-read bool              $IS_RECURRING
 * @property-read string|null       $PROBABILITY
 * @property-read string            $CURRENCY_ID
 * @property-read string            $OPPORTUNITY
 * @property-read bool              $IS_MANUAL_OPPORTUNITY
 * @property-read string            $TAX_VALUE
 * @property-read int               $LEAD_ID
 * @property-read int               $COMPANY_ID
 * @property-read int               $CONTACT_ID
 * @property-read int               $QUOTE_ID
 * @property-read DateTimeInterface $BEGINDATE
 * @property-read DateTimeInterface $CLOSEDATE
 * @property-read bool              $OPENED
 * @property-read bool              $CLOSED
 * @property-read string|null       $COMMENTS
 * @property-read string|null       $ADDITIONAL_INFO
 * @property-read string|null       $LOCATION_ID
 * @property-read bool              $IS_RETURN_CUSTOMER
 * @property-read bool              $IS_REPEATED_APPROACH
 * @property-read int|null          $SOURCE_ID
 * @property-read string|null       $SOURCE_DESCRIPTION
 * @property-read string|null       $ORIGINATOR_ID
 * @property-read string|null       $ORIGIN_ID
 * @property-read string|null       $UTM_SOURCE
 * @property-read string|null       $UTM_MEDIUM
 * @property-read string|null       $UTM_CAMPAIGN
 * @property-read string|null       $UTM_CONTENT
 * @property-read string|null       $UTM_TERM
 */
class DealItemResult extends AbstractCrmItem
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