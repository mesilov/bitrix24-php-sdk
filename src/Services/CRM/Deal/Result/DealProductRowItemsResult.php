<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealProductRowItemsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealProductRowItemsResult extends AbstractResult
{
    /**
     * @return DealProductRowItemResult[]
     * @throws BaseException
     */
    public function getProductRows(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $productRow) {
            $res[] = new DealProductRowItemResult($productRow);
        }

        return $res;
    }
}