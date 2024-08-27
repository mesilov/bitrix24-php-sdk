<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

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