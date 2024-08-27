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
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Core\Result\AbstractResult;
use Money\Currency;

/**
 * Class DealProductRowItemsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealProductRowItemsResult extends AbstractResult
{
    private Currency $currency;

    public function __construct(Response $coreResponse,Currency $currency)
    {
        parent::__construct($coreResponse);
        $this->currency = $currency;
    }

    /**
     * @return DealProductRowItemResult[]
     * @throws BaseException
     */
    public function getProductRows(): array
    {
        $res = [];
        if(!empty($this->getCoreResponse()->getResponseData()->getResult()['result']['rows'])) {
            foreach ($this->getCoreResponse()->getResponseData()->getResult()['result']['rows'] as $productRow) {
                $res[] = new DealProductRowItemResult($productRow, $this->currency);
            }
        } else {
            foreach ($this->getCoreResponse()->getResponseData()->getResult() as $productRow) {
                $res[] = new DealProductRowItemResult($productRow, $this->currency);
            }
        }

        return $res;
    }
}