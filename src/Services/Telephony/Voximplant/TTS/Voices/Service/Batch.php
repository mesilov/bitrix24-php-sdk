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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\TTS\Voices\Service;

use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Psr\Log\LoggerInterface;

readonly class Batch
{
    public function __construct(
        protected BatchOperationsInterface $batch,
        protected LoggerInterface          $log)
    {
    }
}