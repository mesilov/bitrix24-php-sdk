<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ActivityResult extends AbstractResult
{
    public function activity(): ActivityItemResult
    {
        return new ActivityItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}