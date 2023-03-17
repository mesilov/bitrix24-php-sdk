<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\User\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;
use Bitrix24\SDK\Services\CRM\Contact\Result\ContactItemResult;

class UsersResult extends AbstractResult
{
    /**
     * @return UserItemResult[]
     * @throws BaseException
     */
    public function getUsers(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new UserItemResult($item);
        }

        return $res;
    }
}