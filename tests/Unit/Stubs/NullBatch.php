<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Stubs;

use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;
use Generator;

/**
 * Class NullCore
 *
 * @package Bitrix24\SDK\Tests\Unit\Stubs
 */
class NullBatch implements BatchOperationsInterface
{

    /**
     * @param string $apiMethod
     * @param array $order
     * @param array $filter
     * @param array $select
     * @param int|null $limit
     * @param array|null $additionalParameters
     * @inheritDoc
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null, ?array $additionalParameters = null): Generator
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

    /**
     * @inheritDoc
     */
    public function updateEntityItems(string $apiMethod, array $entityItems): Generator
    {
        yield [];
    }
}