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
 * Class DealCategoriesResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealCategoriesResult extends AbstractResult
{
    /**
     * @return DealCategoryItemResult[]
     * @throws BaseException
     */
    public function getDealCategories(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $dealCategory) {
            $res[] = new DealCategoryItemResult($dealCategory);
        }

        return $res;
    }
}