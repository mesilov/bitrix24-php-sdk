<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class DealUserfieldResult extends AbstractResult
{
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function userfieldItem(): DealUserfieldItemResult
    {
        return new DealUserfieldItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}