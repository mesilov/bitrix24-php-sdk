<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\User\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class UserResult extends AbstractResult
{
    public function user(): UserItemResult
    {
        return new UserItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}