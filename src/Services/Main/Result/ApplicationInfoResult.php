<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ApplicationInfoResult extends AbstractResult
{
    public function applicationInfo(): ApplicationInfoItemResult
    {
        return new ApplicationInfoItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}