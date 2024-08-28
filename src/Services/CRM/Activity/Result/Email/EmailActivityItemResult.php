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

use Bitrix24\SDK\Services\CRM\Activity\Result\ActivityItemResult;

/**
 * @property-read \Bitrix24\SDK\Services\CRM\Activity\Result\Email\EmailSettings $SETTINGS
 */
class EmailActivityItemResult extends ActivityItemResult
{
    public function __get($offset)
    {
        if ($offset === 'SETTINGS') {
            return new EmailSettings($this->data[$offset]);
        }

        return parent::__get($offset);
    }
}