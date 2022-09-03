<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;
use DateTimeImmutable;

class ServerTimeResult extends AbstractResult
{
    /**
     * @return \DateTimeImmutable
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Exception
     */
    public function time(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->getCoreResponse()->getResponseData()->getResult()[0]);
    }
}