<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Stubs;

use Bitrix24\SDK\Core\Contracts\BatchOperationsInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\DTO\Pagination;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;
use Bitrix24\SDK\Core\Response\DTO\Time;
use DateTimeImmutable;
use Generator;

class NullBatch implements BatchOperationsInterface
{

    /**
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
        yield new ResponseData([],new Time(0,0,0,0,0, new DateTimeImmutable(),new DateTimeImmutable(),0,),new Pagination());
    }

    /**
     * @inheritDoc
     */
    public function deleteEntityItems(string $apiMethod, array $entityItemId): Generator
    {
        yield new ResponseData([],new Time(0,0,0,0,0, new DateTimeImmutable(),new DateTimeImmutable(),0,),new Pagination());
    }

    /**
     * @inheritDoc
     */
    public function updateEntityItems(string $apiMethod, array $entityItems): Generator
    {
        yield new ResponseData([],new Time(0,0,0,0,0, new DateTimeImmutable(),new DateTimeImmutable(),0,),new Pagination());
    }
}