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

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealsResult extends AbstractResult
{
    /**
     * @return DealItemResult[]
     * @throws BaseException
     */
    public function getDeals(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $deal) {
            $res[] = new DealItemResult($deal);
        }

        return $res;
    }
}