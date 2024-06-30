<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Task\Service;

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