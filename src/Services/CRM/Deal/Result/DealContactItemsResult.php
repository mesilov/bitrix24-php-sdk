<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealContactItemsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealContactItemsResult extends AbstractResult
{
    /**
     * @return DealContactItemResult[]
     * @throws BaseException
     */
    public function getDealContacts(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $dealContact) {
            $res[] = new DealContactItemResult($dealContact);
        }

        return $res;
    }
}