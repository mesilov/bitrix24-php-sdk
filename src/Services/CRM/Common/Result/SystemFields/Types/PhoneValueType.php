<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types;

enum PhoneValueType:string
{
    case work='WORK';
    case mobile='MOBILE';
    case fax='FAX';
    case home='HOME';
    case pager='PAGER';
    case mailing='MAILING';
    case other='OTHER';
}