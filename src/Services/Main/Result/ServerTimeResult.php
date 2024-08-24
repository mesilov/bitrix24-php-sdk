<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;
use Carbon\CarbonImmutable;
use Exception;

class ServerTimeResult extends AbstractResult
{
    /**
     * @throws BaseException
     * @throws Exception
     */
    public function time(): CarbonImmutable
    {
        return new CarbonImmutable($this->getCoreResponse()->getResponseData()->getResult()[0]);
    }
}