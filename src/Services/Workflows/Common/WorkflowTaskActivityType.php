<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Common;

enum WorkflowTaskActivityType: string
{
    case approveActivity = 'ApproveActivity';
    case reviewActivity = 'ReviewActivity';
    case requestInformationActivity = 'RequestInformationActivity';
    case requestInformationOptionalActivity = 'RequestInformationOptionalActivity';
}