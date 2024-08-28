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

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * Class DealItemResult
 *
 * @property-read int    $CONTACT_ID
 * @property-read int    $SORT
 * @property-read int    $ROLE_ID
 * @property-read string $IS_PRIMARY
 */
class DealContactItemResult extends AbstractItem
{
}