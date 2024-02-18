<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Product\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ProductsResult extends AbstractResult
{
    /**
     * @return ProductItemResult[]
     * @throws BaseException
     */
    public function getProducts(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()['products'] as $product) {
            $res[] = new ProductItemResult($product);
        }

        return $res;
    }
}