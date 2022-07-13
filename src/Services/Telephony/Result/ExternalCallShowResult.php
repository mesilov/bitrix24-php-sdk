<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Contracts\AddedItemIdResultInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallShowResult extends AbstractResult
{

    /**
     * @return bool
     * @throws BaseException
     */

    public function isShown(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()->getResultData()[0];
    }


}