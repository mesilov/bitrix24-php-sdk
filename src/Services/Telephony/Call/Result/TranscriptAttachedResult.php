<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Call\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class TranscriptAttachedResult extends AbstractResult
{
    public function getTranscriptAttachItem(): TranscriptAttachItemResult
    {
        return new TranscriptAttachItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}