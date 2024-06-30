<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class SipLinesResult extends AbstractResult
{
    /**
     * @return SipLineItemResult[]
     * @throws BaseException
     */
    public function getLines(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $line) {
            $res[] = new SipLineItemResult($line);
        }

        return $res;
    }
}