<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal;

/**
 * Status type identifier (STAGE_SEMANTIC_ID), line:
 * "F": "(failed) - processed unsuccessfully",
 * "S": "(success) - processed successfully",
 * "P": "(processing) - deal in process"
 */
enum DealStageSemanticId: string
{
    case process = 'P';
    case success = 'S';
    case failure = 'F';
}