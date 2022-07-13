<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallHideResult extends AbstractResult
{

    /**
     * @return bool
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */

    public function isHided(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()->getResultData()[0];
    }
}