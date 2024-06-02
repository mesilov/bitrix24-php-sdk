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
 * @property-read  int $FILE_ID
 */
class CallRecordFileUploadedItemResult extends AbstractItem
{
}