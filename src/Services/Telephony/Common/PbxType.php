<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

enum PbxType: string
{
    case cloud = 'cloud';
    case office = 'office';
}