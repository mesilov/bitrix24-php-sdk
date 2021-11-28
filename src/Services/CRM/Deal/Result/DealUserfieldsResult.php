<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class DealUserfieldsResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\CRM\Deal\Result\DealUserfieldItemResult[]
     * @throws BaseException
     */
    public function getUserfields(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $item) {
            $res[] = new DealUserfieldItemResult($item);
        }

        return $res;
    }
}