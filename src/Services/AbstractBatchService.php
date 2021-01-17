<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Batch
 *
 * @package Bitrix24\SDK\Services\CRM\Contact\Service
 */
abstract class AbstractBatchService
{
    protected BatchInterface $batch;
    protected LoggerInterface $log;

    /**
     * Batch constructor.
     *
     * @param BatchInterface  $batch
     * @param LoggerInterface $log
     */
    public function __construct(BatchInterface $batch, LoggerInterface $log)
    {
        $this->batch = $batch;
        $this->log = $log;
    }
}