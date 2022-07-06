<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalLinesResult extends AbstractResult
{
    /**
     * @return ExternalLineItemResult[]
     * @throws BaseException
     */
    public function getExternalLines(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $item) {
            $res[] = new ExternalLineItemResult($item);
        }

        return $res;
    }
}