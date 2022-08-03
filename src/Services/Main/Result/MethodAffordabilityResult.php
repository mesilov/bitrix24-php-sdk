<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class MethodAffordabilityResult extends AbstractResult
{
    /**
     * @return bool
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function isExisting(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()['isExisting'];
    }

    /**
     * @return bool
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function isAvailable(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()['isAvailable'];
    }
}