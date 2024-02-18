<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Product\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ProductResult extends AbstractResult
{
    public function product(): ProductItemResult
    {
        if (array_key_exists('element', $this->getCoreResponse()->getResponseData()->getResult())) {
            // fix for catalog.product.add
            return new ProductItemResult($this->getCoreResponse()->getResponseData()->getResult()['element']);
        }
        return new ProductItemResult($this->getCoreResponse()->getResponseData()->getResult()['product']);
    }
}