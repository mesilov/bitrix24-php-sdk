<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalLine\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalLineAddedResult extends AbstractResult
{
    public function getExternalLineAddResultItem(): ExternalLineAddItemResult
    {
        return new ExternalLineAddItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}