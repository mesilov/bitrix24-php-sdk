<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IMOpenLines\Result;

use Bitrix24\SDK\Core\Contracts\AddedItemIdResultInterface;
use Bitrix24\SDK\Core\Result\AbstractResult;

class JoinOpenLineResult extends AbstractResult implements AddedItemIdResultInterface
{
    /**
     * @return int
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getId(): int
    {
        return (int)$this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}