<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Product\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ProductResult extends AbstractResult
{
    public function product(): ProductItemResult
    {
        return new ProductItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}