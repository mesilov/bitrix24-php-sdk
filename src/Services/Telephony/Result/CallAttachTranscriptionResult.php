<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class CallAttachTranscriptionResult extends AbstractResult
{
    /**
     * @return int
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */

    public function getCallTranscription():int
    {
        return $this->getCoreResponse()->getResponseData()->getResult()->getResultData()['TRANSCRIPT_ID'];
    }
}