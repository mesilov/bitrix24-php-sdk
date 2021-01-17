<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;

/**
 * Class AddedItemResult
 *
 * @package Bitrix24\SDK\Core\Result
 */
class AddedItemResult extends AbstractResult
{
    /**
     * @return int
     * @throws BaseException
     */
    public function getId(): int
    {
        return (int)$this->getCoreResponse()->getResponseData()->getResult()->getResultData()[0];
    }
}