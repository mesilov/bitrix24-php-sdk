<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Duplicates\Service;

enum EntityType: string
{
    case Lead = 'LEAD';
    case Contact = 'CONTACT';
    case Company = 'COMPANY';
}