<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalLine\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalLinesResult extends AbstractResult
{
    public function getExternalLines(): array
    {
        $lines = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $line) {
            $lines[] = new ExternalLineItemResult($line);
        }
        return $lines;
    }
}