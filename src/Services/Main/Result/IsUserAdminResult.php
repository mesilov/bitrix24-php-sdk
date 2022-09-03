<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class IsUserAdminResult extends AbstractResult
{
    /**
     * @return bool
     * @throws BaseException
     */
    public function isAdmin(): bool
    {
        return (bool)$this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}