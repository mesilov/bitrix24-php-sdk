<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;

/**
 * Class FieldsResult
 *
 * @package Bitrix24\SDK\Core\Result
 */
class FieldsResult extends AbstractResult
{
    /**
     * @return array
     * @throws BaseException
     */
    public function getFieldsDescription(): array
    {
        return $this->getCoreResponse()->getResponseData()->getResult()->getResultData();
    }
}