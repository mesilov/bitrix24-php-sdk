<?php

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