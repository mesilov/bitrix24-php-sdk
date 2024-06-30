<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Contracts\UpdatedItemResultInterface;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;

class UpdatedItemBatchResult implements UpdatedItemResultInterface
{
    public function __construct(private readonly ResponseData $responseData)
    {
    }

    public function getResponseData(): ResponseData
    {
        return $this->responseData;
    }

    public function isSuccess(): bool
    {
        return (bool)$this->getResponseData()->getResult()[0];
    }
}