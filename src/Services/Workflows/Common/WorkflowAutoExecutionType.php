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

enum WorkflowAutoExecutionType: int
{
    case  withoutAutoExecution = 0;
    case whenAdded = 1;
    case whenModified = 2;
    case whenAddedAndModified = 3;
}
