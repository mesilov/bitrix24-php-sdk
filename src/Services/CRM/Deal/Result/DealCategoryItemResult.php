<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use DateTimeImmutable;

/**
 * Class DealItemResult
 *
 * @property int               $ID
 * @property DateTimeImmutable $CREATED_DATE
 * @property string            $NAME
 * @property bool              $IS_LOCKED
 * @property int               $SORT
 */
class DealCategoryItemResult extends AbstractCrmItem
{
}