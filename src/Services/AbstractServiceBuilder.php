<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;


use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractServiceBuilder
 *
 * @package Bitrix24\SDK\Services
 */
abstract class AbstractServiceBuilder
{
    protected CoreInterface $core;
    protected BatchInterface $batch;
    protected BulkItemsReaderInterface $bulkItemsReader;
    protected LoggerInterface $log;
    protected array $serviceCache;

    /**
     * AbstractServiceBuilder constructor.
     *
     * @param CoreInterface                                         $core
     * @param BatchInterface                                        $batch
     * @param \Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface $bulkItemsReader
     * @param LoggerInterface                                       $log
     */
    public function __construct(
        CoreInterface $core,
        BatchInterface $batch,
        BulkItemsReaderInterface $bulkItemsReader,
        LoggerInterface $log
    ) {
        $this->core = $core;
        $this->batch = $batch;
        $this->bulkItemsReader = $bulkItemsReader;
        $this->log = $log;
    }
}