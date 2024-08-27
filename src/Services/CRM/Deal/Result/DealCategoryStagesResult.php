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
 * Class DealCategoryStagesResult
 *
 * @property string $NAME
 * @property int    $SORT
 * @property string $STATUS_ID
 */
class DealCategoryStagesResult extends AbstractResult
{
    /**
     * @return DealCategoryStageItemResult[]
     * @throws BaseException
     */
    public function getDealCategoryStages(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $deal) {
            $res[] = new DealCategoryStageItemResult($deal);
        }

        return $res;
    }
}