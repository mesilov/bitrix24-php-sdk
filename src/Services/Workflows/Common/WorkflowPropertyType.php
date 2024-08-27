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

namespace Bitrix24\SDK\Services\Workflows\Common;

enum WorkflowPropertyType: string
{
    case bool = 'bool';
    case date = 'date';
    case datetime = 'datetime';
    case double = 'double';
    case int = 'int';
    case select = 'select';
    case string = 'string';
    case text = 'text';
    case user = 'user';
}