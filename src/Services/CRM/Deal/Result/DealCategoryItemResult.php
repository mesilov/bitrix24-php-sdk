<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use Carbon\CarbonImmutable;

/**
 * Class DealItemResult
 *
 * @property int               $ID
 * @property CarbonImmutable $CREATED_DATE
 * @property string            $NAME
 * @property bool              $IS_LOCKED
 * @property int               $SORT
 */
class DealCategoryItemResult extends AbstractCrmItem
{
}