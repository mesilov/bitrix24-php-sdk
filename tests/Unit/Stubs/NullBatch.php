<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Stubs;

use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Generator;

/**
 * Class NullCore
 *
 * @package Bitrix24\SDK\Tests\Unit\Stubs
 */
class NullBatch implements BatchInterface
{

    /**
     * @inheritDoc
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        yield [];
    }

    /**
     * @inheritDoc
     */
    public function getTraversableListWithCount(
        string $apiMethod,
        array $order,
        array $filter,
        array $select,
        ?int $limit = null
    ): Generator {
        yield [];
    }

    /**
     * @inheritDoc
     */
    public function addEntityItems(string $apiMethod, array $entityItems): Generator
    {
        yield [];
    }

    /**
     * @inheritDoc
     */
    public function deleteEntityItems(string $apiMethod, array $entityItemId): Generator
    {
        yield [];
    }
}