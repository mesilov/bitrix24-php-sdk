<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealResult extends AbstractResult
{
    public function deal(): DealItemResult
    {
        return new DealItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}