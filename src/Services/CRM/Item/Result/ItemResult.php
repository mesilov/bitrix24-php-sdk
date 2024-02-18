<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Item\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ItemResult extends AbstractResult
{
    public function item(): ItemItemResult
    {
        return new ItemItemResult($this->getCoreResponse()->getResponseData()->getResult()['item']);
    }
}