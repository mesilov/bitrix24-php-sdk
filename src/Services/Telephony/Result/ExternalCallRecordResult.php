<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallRecordResult extends AbstractResult
{
    /**
     * @return array
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getRecord():array
    {
     return  $this->getCoreResponse()->getResponseData()->getResult()->getResultData();
    }
}