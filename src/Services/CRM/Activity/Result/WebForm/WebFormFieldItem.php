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

namespace Bitrix24\SDK\Services\CRM\Activity\Result\WebForm;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $type
 * @property-read string $code
 * @property-read bool   $required
 * @property-read string $caption
 * @property-read array  $value
 */
class WebFormFieldItem extends AbstractItem
{
}

