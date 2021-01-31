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
     * @param string   $apiMethod
     * @param array    $order
     * @param array    $filter
     * @param array    $select
     * @param int|null $limit
     *
     * @return Generator
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        yield [];
    }

    /**
     * @param string $apiMethod
     * @param array  $entityItems
     *
     * @return Generator
     */
    public function addEntityItems(string $apiMethod, array $entityItems): Generator
    {
        yield [];
    }
}