<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Generator;

/**
 * Interface BatchInterface
 *
 * @package Bitrix24\SDK\Core\Contracts
 */
interface BatchInterface
{

    /**
     * batch wrapper for *.list methods
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
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator;
}