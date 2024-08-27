<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Contracts\DeletedItemResultInterface;
use Bitrix24\SDK\Core\Response\DTO\ResponseData;

class DeletedItemBatchResult implements DeletedItemResultInterface
{
    public function __construct(private readonly ResponseData $responseData)
    {
    }

    public function getResponseData(): ResponseData
    {
        return $this->responseData;
    }

    public function isSuccess(): bool
    {
        return (bool)$this->getResponseData()->getResult()[0];
    }
}