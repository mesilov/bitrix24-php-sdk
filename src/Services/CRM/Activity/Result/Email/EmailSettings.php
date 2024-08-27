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
 * @property-read bool|null      $IS_BATCH_EMAIL
 * @property-read array|null     $MESSAGE_HEADERS
 * @property-read EmailMeta|null $EMAIL_META
 */
class EmailSettings extends AbstractItem
{
    public function __get($offset)
    {
        if ($offset === 'EMAIL_META') {
            if (array_key_exists($offset, $this->data)) {
                return new EmailMeta($this->data[$offset]);
            }

            return null;
        }

        return parent::__get($offset);
    }
}