<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Contracts\DeletedItemResultInterface;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;

class DeletedItemBatchResult implements DeletedItemResultInterface
{
    private ResponseData $responseData;

    /**
     * @param \Bitrix24\SDK\Core\Response\DTO\ResponseData $responseData
     */
    public function __construct(ResponseData $responseData)
    {
        $this->responseData = $responseData;
    }

    /**
     * @return \Bitrix24\SDK\Core\Response\DTO\ResponseData
     */
    public function getResponseData(): ResponseData
    {
        return $this->responseData;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return (bool)$this->getResponseData()->getResult()->getResultData()[0];
    }
}