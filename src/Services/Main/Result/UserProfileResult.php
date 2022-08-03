<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class UserProfileResult extends AbstractResult
{
    public function getUserProfile(): UserProfileItemResult
    {
        return new UserProfileItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}