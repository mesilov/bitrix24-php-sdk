<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\BulkItemsReader;

use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Generator;
use Psr\Log\LoggerInterface;

class BulkItemsReader implements BulkItemsReaderInterface
{
    protected BulkItemsReaderInterface $readStrategy;
    protected LoggerInterface $logger;

    /**
     * @param \Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface $readStrategy
     * @param \Psr\Log\LoggerInterface                              $logger
     */
    public function __construct(BulkItemsReaderInterface $readStrategy, LoggerInterface $logger)
    {
        $this->readStrategy = $readStrategy;
        $this->logger = $logger;
    }

    /**
     * @param string   $apiMethod
     * @param array    $order
     * @param array    $filter
     * @param array    $select
     * @param int|null $limit
     *
     * @return \Generator
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        foreach ($this->readStrategy->getTraversableList($apiMethod, $order, $filter, $select, $limit) as $cnt => $item) {
            yield $cnt => $item;
        }
    }
}

