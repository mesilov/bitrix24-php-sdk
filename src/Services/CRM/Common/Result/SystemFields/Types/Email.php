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

namespace Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $VALUE
 * @property-read int $ID
 * @property-read PhoneValueType $VALUE_TYPE
 */
class Email extends AbstractItem
{
    public function __get($offset)
    {
        return match ($offset) {
            'VALUE' => $this->data[$offset],
            'ID' => (int)$this->data['ID'],
            'VALUE_TYPE' => EmailValueType::from($this->data['VALUE_TYPE']),
            default => parent::__get($offset),
        };
    }
}