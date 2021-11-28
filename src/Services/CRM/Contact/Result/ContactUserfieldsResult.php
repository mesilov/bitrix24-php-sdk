<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Contact\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ContactUserfieldsResult extends AbstractResult
{
    /**
     * @return ContactUserfieldItemResult[]
     * @throws BaseException
     */
    public function getUserfields(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $item) {
            $res[] = new ContactUserfieldItemResult($item);
        }

        return $res;
    }
}