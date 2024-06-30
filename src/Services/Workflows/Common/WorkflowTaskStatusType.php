<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Common;

enum WorkflowTaskStatusType: int
{
    case inProgress = 0;
    case approved = 1;
    case rejected = 2;
    case completed = 3;
    case timeOut = 4;
}