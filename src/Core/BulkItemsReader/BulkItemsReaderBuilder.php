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

namespace Bitrix24\SDK\Core\BulkItemsReader;

use Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies\FilterWithBatchWithoutCountOrder;
use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Psr\Log\LoggerInterface;

class BulkItemsReaderBuilder
{
    protected BulkItemsReaderInterface $readStrategy;

    public function __construct(protected CoreInterface $core, protected BatchOperationsInterface $batch, protected LoggerInterface $logger)
    {
        $this->readStrategy = $this->getOptimalReadStrategy();
    }

    
    public function withReadStrategy(BulkItemsReaderInterface $bulkItemsReader): BulkItemsReaderBuilder
    {
        $this->readStrategy = $bulkItemsReader;

        return $this;
    }

    /**
     * Get optimal read strategy based on integration tests with time and performance benchmarks
     */
    protected function getOptimalReadStrategy(): BulkItemsReaderInterface
    {
        return new FilterWithBatchWithoutCountOrder($this->batch, $this->logger);
    }

    public function build(): BulkItemsReaderInterface
    {
        return new BulkItemsReader($this->readStrategy, $this->logger);
    }
}