<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class CallRecordFileUploadedResult extends AbstractResult
{
    public function getRecordUploadedResult(): CallRecordFileUploadedItemResult
    {
        return new CallRecordFileUploadedItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}