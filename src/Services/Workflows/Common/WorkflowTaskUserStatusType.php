<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Common;

enum WorkflowTaskUserStatusType: int
{
    case waitingForResponse = 0;
    case approved = 1;
    case rejected = 2;
    case completed = 3;
}