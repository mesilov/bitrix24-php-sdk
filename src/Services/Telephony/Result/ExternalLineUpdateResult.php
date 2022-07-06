<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalLineUpdateResult extends AbstractResult
{
    /**
     * @return int
     * @throws BaseException
     */
    public function updateExternalLineId():int
    {
        return (int)$this->getCoreResponse()->getResponseData()->getResult()->getResultData()['ID'];
    }
}