<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealCategoryResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealCategoryResult extends AbstractResult
{
    public function getDealCategoryFields(): DealCategoryItemResult
    {
        return new DealCategoryItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}