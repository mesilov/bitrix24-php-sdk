<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Contracts\AddedItemIdResultInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalLineAddResult extends AbstractResult implements AddedItemIdResultInterface
{
    /**
     * @return int
     * @throws BaseException
     */
    public function getId(): int
    {
        return $this->getCoreResponse()->getResponseData()->getResult()->getResultData()['ID'];
    }

}