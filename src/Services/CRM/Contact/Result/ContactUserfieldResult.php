<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Contact\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ContactUserfieldResult extends AbstractResult
{
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function userfieldItem(): ContactUserfieldItemResult
    {
        return new ContactUserfieldItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}