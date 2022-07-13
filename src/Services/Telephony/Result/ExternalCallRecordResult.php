<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallRecordResult extends AbstractResult
{
    /**
     * @return int
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getFileId():int
    {
     return  $this->getCoreResponse()->getResponseData()->getResult()->getResultData()['FILE_ID'];
    }
}