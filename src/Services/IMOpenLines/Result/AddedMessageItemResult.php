<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IMOpenLines\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;


class AddedMessageItemResult extends AbstractResult
{
    /**
     * @throws BaseException
     */
    public function isSuccess(): bool
    {
        return (bool)$this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}