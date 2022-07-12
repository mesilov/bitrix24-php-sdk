<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallFinishResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallFinishItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getExternalCallFinish(): ExternalCallFinishItemResult
    {
        return new ExternalCallFinishItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}