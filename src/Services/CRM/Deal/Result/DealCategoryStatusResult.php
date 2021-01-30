<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealCategoryStatusResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealCategoryStatusResult extends AbstractResult
{
    /**
     * @return string
     * @throws BaseException
     */
    public function getDealCategoryTypeId(): string
    {
        return $this->getCoreResponse()->getResponseData()->getResult()->getResultData()[0];
    }
}