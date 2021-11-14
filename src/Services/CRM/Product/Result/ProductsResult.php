<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Product\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Product\Result
 */
class ProductsResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\CRM\Product\Result\ProductItemResult[]
     * @throws BaseException
     */
    public function getProducts(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $item) {
            $res[] = new ProductItemResult($item);
        }

        return $res;
    }
}