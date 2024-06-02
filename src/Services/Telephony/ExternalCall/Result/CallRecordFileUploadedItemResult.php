<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntity;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

/**
 * @property-read  non-empty-string $uploadUrl
 * @property-read  non-empty-string $fieldName
 */
class CallRecordFileUploadedItemResult extends AbstractItem
{
}