<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

enum DealSemanticStage: string
{
    case underway = 'P';
    case successful = 'S';
    case failed = 'F';
}