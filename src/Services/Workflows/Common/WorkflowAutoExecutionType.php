<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Common;

enum WorkflowAutoExecutionType: int
{
    case  withoutAutoExecution = 0;
    case whenAdded = 1;
    case whenModified = 2;
    case whenAddedAndModified = 3;
}
