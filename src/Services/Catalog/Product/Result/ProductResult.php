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

namespace Bitrix24\SDK\Services\Catalog\Product\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class ProductResult extends AbstractResult
{
    public function product(): ProductItemResult
    {
        if (array_key_exists('element', $this->getCoreResponse()->getResponseData()->getResult())) {
            // fix for catalog.product.add
            return new ProductItemResult($this->getCoreResponse()->getResponseData()->getResult()['element']);
        }

        return new ProductItemResult($this->getCoreResponse()->getResponseData()->getResult()['product']);
    }
}