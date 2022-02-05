<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\BulkItemsReader;

use Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies\FilterWithBatchWithoutCountOrder;
use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Psr\Log\LoggerInterface;

class BulkItemsReaderBuilder
{
    protected CoreInterface $core;
    protected BatchInterface $batch;
    protected LoggerInterface $logger;
    protected BulkItemsReaderInterface $readStrategy;

    /**
     * @param \Bitrix24\SDK\Core\Contracts\CoreInterface  $core
     * @param \Bitrix24\SDK\Core\Contracts\BatchInterface $batch
     * @param \Psr\Log\LoggerInterface                    $logger
     */
    public function __construct(CoreInterface $core, BatchInterface $batch, LoggerInterface $logger)
    {
        $this->core = $core;
        $this->batch = $batch;
        $this->logger = $logger;
        $this->readStrategy = $this->getOptimalReadStrategy();
    }

    /**
     * @param \Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface $readStrategy
     *
     * @return BulkItemsReaderBuilder
     */
    public function withReadStrategy(BulkItemsReaderInterface $readStrategy): BulkItemsReaderBuilder
    {
        $this->readStrategy = $readStrategy;

        return $this;
    }

    /**
     * Get optimal read strategy based on integration tests with time and performance benchmarks
     *
     * @return \Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface
     */
    protected function getOptimalReadStrategy(): BulkItemsReaderInterface
    {
        return new FilterWithBatchWithoutCountOrder($this->batch, $this->logger);
    }

    /**
     * @return \Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface
     */
    public function build(): BulkItemsReaderInterface
    {
        return new BulkItemsReader($this->readStrategy, $this->logger);
    }
}