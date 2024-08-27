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

use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Generator;
use Psr\Log\LoggerInterface;

class BulkItemsReader implements BulkItemsReaderInterface
{
    public function __construct(protected BulkItemsReaderInterface $readStrategy, protected LoggerInterface $logger)
    {
    }

    /**
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        foreach ($this->readStrategy->getTraversableList($apiMethod, $order, $filter, $select, $limit) as $cnt => $item) {
            yield $cnt => $item;
        }
    }
}

