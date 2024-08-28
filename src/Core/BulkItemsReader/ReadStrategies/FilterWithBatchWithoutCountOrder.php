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

namespace Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies;

use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Generator;
use Psr\Log\LoggerInterface;

class FilterWithBatchWithoutCountOrder implements BulkItemsReaderInterface
{
    public function __construct(private readonly BatchOperationsInterface $batch, private readonly LoggerInterface $log)
    {
    }

    /**
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug('FilterWithBatchWithoutCountOrder.getTraversableList.start', [
            'apiMethod' => $apiMethod,
            'order'     => $order,
            'filter'    => $filter,
            'select'    => $select,
            'limit'     => $limit,
        ]);

        foreach ($this->batch->getTraversableList($apiMethod, $order, $filter, $select, $limit) as $cnt => $resultItem) {
            yield $cnt => $resultItem;
        }

        $this->log->debug('FilterWithBatchWithoutCountOrder.getTraversableList.finish');
    }
}