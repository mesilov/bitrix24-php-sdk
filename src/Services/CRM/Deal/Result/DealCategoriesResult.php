<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealCategoriesResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealCategoriesResult extends AbstractResult
{
    /**
     * @return DealCategoryItemResult[]
     * @throws BaseException
     */
    public function getDealCategories(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $dealCategory) {
            $res[] = new DealCategoryItemResult($dealCategory);
        }

        return $res;
    }
}