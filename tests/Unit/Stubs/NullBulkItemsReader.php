<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Stubs;

use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Generator;

class NullBulkItemsReader implements BulkItemsReaderInterface
{
    /**
     * @inheritDoc
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        yield [];
    }
}