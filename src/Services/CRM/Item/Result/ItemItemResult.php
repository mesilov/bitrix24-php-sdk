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

namespace Bitrix24\SDK\Services\CRM\Item\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use Carbon\CarbonImmutable;
use Money\Currency;

/**
 * @property-read int $id
 * @property-read string $xmlId
 * @property-read string $title
 * @property-read int $createdBy
 * @property-read int $updatedBy
 * @property-read int $movedBy
 * @property-read CarbonImmutable $createdTime
 * @property-read CarbonImmutable $updatedTime
 * @property-read CarbonImmutable $movedTime
 * @property-read int $categoryId
 * @property-read bool $opened
 * @property-read string $previousStageId
 * @property-read CarbonImmutable $begindate
 * @property-read CarbonImmutable $closedate
 * @property-read int $companyId
 * @property-read int $contactId
 * @property-read int $opportunity
 * @property-read bool $isManualOpportunity
 * @property-read int $taxValue
 * @property-read Currency $currencyId
 * @property-read int $opportunityAccount
 * @property-read int $taxValueAccount
 * @property-read Currency $accountCurrencyId
 * @property-read int $mycompanyId
 * @property-read string $sourceId
 * @property-read string $sourceDescription
 * @property-read int $webformId
 * @property-read int $assignedById
 * @property-read int $lastActivityBy
 * @property-read CarbonImmutable $lastActivityTime
 * @property-read string $utmSource
 * @property-read string $utmMedium
 * @property-read string $utmCampaign
 * @property-read string $utmContent
 * @property-read string $utmTerm
 * @property-read array $observers
 * @property-read array $contactIds
 * @property-read int $entityTypeId
 */
class ItemItemResult extends AbstractCrmItem
{
}