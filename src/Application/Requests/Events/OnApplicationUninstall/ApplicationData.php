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

namespace Bitrix24\SDK\Application\Requests\Events\OnApplicationUninstall;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $CLEAN
 * @property-read string $LANGUAGE_ID
 */
class ApplicationData extends AbstractItem
{
}