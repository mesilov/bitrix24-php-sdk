<?php

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
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $deal) {
            $res[] = new DealCategoryStageItemResult($deal);
        }

        return $res;
    }
}