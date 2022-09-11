<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Lead\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class LeadResult
 *
 * @package Bitrix24\SDK\Services\CRM\Lead\Result
 */
class LeadResult extends AbstractResult
{
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function lead(): LeadItemResult
    {
        return new LeadItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}