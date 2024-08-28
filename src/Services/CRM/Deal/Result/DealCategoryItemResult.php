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