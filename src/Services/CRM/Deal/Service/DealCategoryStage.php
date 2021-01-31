<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealCategoryStagesResult;

/**
 * Class DealCategoryStage
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Service
 */
class DealCategoryStage extends AbstractService
{
    /**
     * @param int $categoryId
     *
     * @return DealCategoryStagesResult
     * @throws BaseException
     * @throws TransportException
     */
    public function list(int $categoryId): DealCategoryStagesResult
    {
        return new DealCategoryStagesResult(
            $this->core->call(
                'crm.dealcategory.stage.list',
                [
                    'id' => $categoryId,
                ]
            )
        );
    }
}