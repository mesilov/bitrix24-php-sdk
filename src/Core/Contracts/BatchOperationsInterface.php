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

namespace Bitrix24\SDK\Core\Contracts;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;
use Generator;

/**
 * Interface BatchOperationsInterface
 *
 * @package Bitrix24\SDK\Core\Contracts
 */
interface BatchOperationsInterface
{
    /**
     * Batch wrapper for *.list methods without counting elements on every api-call
     *
     * @param array<string,mixed> $order
     * @param array<string,mixed> $filter
     * @param array<string,mixed> $select
     * @return Generator<mixed>
     * @throws BaseException
     */
    public function getTraversableList(
        string $apiMethod,
        array $order,
        array $filter,
        array $select,
        ?int $limit = null,
        ?array $additionalParameters = null
    ): Generator;

    /**
     * Batch wrapper for *.list methods with counting elements on every api-call
     *
     * ⚠️ Call this wrapper is more expensive than getTraversableList method, use this method carefully
     *
     *
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
     * @param array<int, array> $entityItems
     *
     * @return Generator<int, ResponseData>|ResponseData[]
     * @throws BaseException
     */
    public function addEntityItems(string $apiMethod, array $entityItems): Generator;

    /**
     * Delete entity items with batch call
     *
     * @param array<int, int> $entityItemId
     *
     * @return Generator<int, ResponseData>|ResponseData[]
     * @throws BaseException
     */
    public function deleteEntityItems(string $apiMethod, array $entityItemId): Generator;

    /**
     * Update entity items with batch call
     *
     * @param array<int, array> $entityItems
     *
     * @return Generator<int, ResponseData>|ResponseData[]
     * @throws BaseException
     */
    public function updateEntityItems(string $apiMethod, array $entityItems): Generator;
}