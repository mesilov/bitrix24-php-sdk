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

namespace Bitrix24\SDK\Services\CRM\Activity\Result\Email;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $__email
 * @property-read string $from
 * @property-read string $replyTo
 * @property-read string $to
 * @property-read string $cc
 * @property-read string $bcc
 */
class EmailMeta extends AbstractItem
{
}