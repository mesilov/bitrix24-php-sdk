<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Product\Service;

use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AddedItemBatchResult;
use Bitrix24\SDK\Core\Result\DeletedItemBatchResult;
use Bitrix24\SDK\Core\Result\UpdatedItemBatchResult;
use Generator;
use Psr\Log\LoggerInterface;

readonly class Batch
{
    public function __construct(
        protected BatchOperationsInterface $batch,
        protected LoggerInterface          $log)
    {
    }
}