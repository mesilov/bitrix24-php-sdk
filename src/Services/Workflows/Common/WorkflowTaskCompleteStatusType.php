<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Common;

enum WorkflowTaskCompleteStatusType: int
{
    case approved = 1;
    case rejected = 2;
    case reviewed = 3;
    case cancelled = 4;
}