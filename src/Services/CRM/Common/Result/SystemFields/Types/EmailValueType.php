<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types;

enum EmailValueType: string
{
    case work = 'WORK';
    case home = 'HOME';
    case other = 'OTHER';
    case mailing = 'MAILING';
}