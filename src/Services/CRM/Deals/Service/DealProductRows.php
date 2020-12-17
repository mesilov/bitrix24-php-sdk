<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deals\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;

/**
 * Class DealProductRows
 *
 * @package Bitrix24\SDK\Services\CRM\Deals\Service
 */
class DealProductRows extends AbstractService
{
    /**
     * @param int $dealId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function get(int $dealId): Response
    {
        $this->log->debug(
            'get.start',
            [
                'dealId' => $dealId,
            ]
        );

        $result = $this->core->call(
            'crm.deal.productrows.get',
            [
                'id' => $dealId,
            ]
        );

        $this->log->debug('get.finish');

        return $result;
    }

    /**
     * @param int   $dealId
     * @param array $productRows
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function set(int $dealId, array $productRows): Response
    {
        $this->log->debug(
            'set.start',
            [
                'dealId'      => $dealId,
                'productRows' => $productRows,
            ]
        );


        $result = $this->core->call(
            'crm.deal.productrows.set',
            [
                'id'   => $dealId,
                'rows' => $productRows,
            ]
        );


        $this->log->debug('set.finish');

        return $result;
    }
}