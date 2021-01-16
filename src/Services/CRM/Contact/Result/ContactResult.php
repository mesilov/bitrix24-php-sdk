<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Contact\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class ContactResult
 *
 * @package Bitrix24\SDK\Services\CRM\Contact\Result
 */
class ContactResult extends AbstractResult
{
    public function contact(): ContactItemResult
    {
        return new ContactItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}