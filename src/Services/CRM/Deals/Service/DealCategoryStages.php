<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deals\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;

/**
 * Class DealCategoryStages
 *
 * @package Bitrix24\SDK\Services\CRM\Deals\Service
 */
class DealCategoryStages extends AbstractService
{
    /**
     * @param int $categoryId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function list(int $categoryId): Response
    {
        $this->log->debug(
            'list.start',
            [
                'categoryId' => $categoryId,
            ]
        );

        $result = $this->core->call('crm.dealcategory.stage.list');

        $this->log->debug('list.finish');

        return $result;
    }
}