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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Url\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read  non-empty-string $detail_statistics
 * @property-read  non-empty-string $buy_connector
 * @property-read  non-empty-string $edit_config
 * @property-read  non-empty-string $lines
 */
class VoximplantPagesItemResult extends AbstractItem
{
}