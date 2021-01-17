<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * Class DealItemResult
 *
 * @property-read int         $ID
 * @property-read string      $TITLE deal title
 * @property-read string|null $TYPE_ID
 * @property-read string|null $CATEGORY_ID
 * @property-read string      $STAGE_ID
 * @property-read string      $STAGE_SEMANTIC_ID
 * @property-read string      $IS_NEW
 * @property-read string      $IS_RECURRING
 * @property-read string|null $PROBABILITY
 * @property-read string      $CURRENCY_ID
 * @property-read string      $OPPORTUNITY
 * @property-read string      $IS_MANUAL_OPPORTUNITY
 * @property-read string      $TAX_VALUE
 * @property-read string      $LEAD_ID
 * @property-read string      $COMPANY_ID
 * @property-read string      $CONTACT_ID
 * @property-read string      $QUOTE_ID
 * @property-read string      $BEGINDATE
 * @property-read string      $CLOSEDATE
 * @property-read string      $OPENED
 * @property-read string      $CLOSED
 * @property-read string|null $COMMENTS
 * @property-read string|null $ADDITIONAL_INFO
 * @property-read string|null $LOCATION_ID
 * @property-read string      $IS_RETURN_CUSTOMER
 * @property-read string      $IS_REPEATED_APPROACH
 * @property-read int|null    $SOURCE_ID
 * @property-read string|null $SOURCE_DESCRIPTION
 * @property-read string|null $ORIGINATOR_ID
 * @property-read string|null $ORIGIN_ID
 * @property-read string|null $UTM_SOURCE
 * @property-read string|null $UTM_MEDIUM
 * @property-read string|null $UTM_CAMPAIGN
 * @property-read string|null $UTM_CONTENT
 * @property-read string|null $UTM_TERM
 */
class DealItemResult extends AbstractItem
{
}