<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class CallRecordUploadUrlResult extends AbstractResult
{
    public function getUploadUrlResult(): CallRecordUploadUrlItemResult
    {
        return new CallRecordUploadUrlItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}