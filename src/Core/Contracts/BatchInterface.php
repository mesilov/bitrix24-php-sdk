<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;
use Generator;

/**
 * Interface BatchInterface
 *
 * @package Bitrix24\SDK\Core\Contracts
 */
interface BatchInterface
{
    /**
     * Batch wrapper for *.list methods without counting elements on every api-call
     *
     * @param string               $apiMethod
     * @param array<string,string> $order
     * @param array<string,mixed>  $filter
     * @param array<string,mixed>  $select
     * @param int|null             $limit
     *
     * @return Generator<mixed>
     * @throws BaseException
     */
    public function getTraversableList(
        string $apiMethod,
        array $order,
        array $filter,
        array $select,
        ?int $limit = null
    ): Generator;

    /**
     * Batch wrapper for *.list methods with counting elements on every api-call
     *
     * ⚠️ Call this wrapper is more expensive than getTraversableList method, use this method carefully
     *
     * @param string   $apiMethod
     * @param array    $order
     * @param array    $filter
     * @param array    $select
     * @param int|null $limit
     *
     * @return Generator
     * @throws BaseException
     */
    public function getTraversableListWithCount(
        string $apiMethod,
        array $order,
        array $filter,
        array $select,
        ?int $limit = null
    ): Generator;

    /**
     * Add entity items with batch call
     *
     * @param string            $apiMethod
     * @param array<int, array> $entityItems
     *
     * @return Generator<int, ResponseData>|ResponseData[]
     * @throws BaseException
     */
    public function addEntityItems(string $apiMethod, array $entityItems): Generator;

    /**
     * Delete entity items with batch call
     *
     * @param string          $apiMethod
     * @param array<int, int> $entityItemId
     *
     * @return Generator<int, ResponseData>|ResponseData[]
     * @throws BaseException
     */
    public function deleteEntityItems(string $apiMethod, array $entityItemId): Generator;

    //todo add updateEntityItems
}