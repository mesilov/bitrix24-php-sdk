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

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use Carbon\CarbonImmutable;
use Money\Currency;

/**
 * Class DealItemResult
 * @property-read int $ID
 * @property-read string|null $TITLE deal title
 * @property-read string|null $TYPE_ID
 * @property-read string|null $CATEGORY_ID
 * @property-read string|null $STAGE_ID
 * @property-read DealSemanticStage|null $STAGE_SEMANTIC_ID
 * @property-read bool|null $IS_NEW
 * @property-read bool|null $IS_RECURRING
 * @property-read string|null $PROBABILITY
 * @property-read Currency|null $CURRENCY_ID
 * @property-read string|null $OPPORTUNITY
 * @property-read bool|null $IS_MANUAL_OPPORTUNITY
 * @property-read string|null $TAX_VALUE
 * @property-read int|null $LEAD_ID
 * @property-read int|null $COMPANY_ID
 * @property-read int|null $CONTACT_ID deprecated
 * @property-read int|null $QUOTE_ID
 * @property-read CarbonImmutable|null $BEGINDATE
 * @property-read CarbonImmutable|null $CLOSEDATE
 * @property-read bool|null $OPENED
 * @property-read bool|null $CLOSED
 * @property-read string|null $COMMENTS
 * @property-read string|null $ADDITIONAL_INFO
 * @property-read string|null $LOCATION_ID
 * @property-read bool|null $IS_RETURN_CUSTOMER
 * @property-read bool|null $IS_REPEATED_APPROACH
 * @property-read int|null $SOURCE_ID
 * @property-read string|null $SOURCE_DESCRIPTION
 * @property-read string|null $ORIGINATOR_ID
 * @property-read string|null $ORIGIN_ID
 * @property-read string|null $UTM_SOURCE
 * @property-read string|null $UTM_MEDIUM
 * @property-read string|null $UTM_CAMPAIGN
 * @property-read string|null $UTM_CONTENT
 * @property-read string|null $UTM_TERM
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